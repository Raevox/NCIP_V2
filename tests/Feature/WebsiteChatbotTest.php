<?php

namespace Tests\Feature;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class WebsiteChatbotTest extends TestCase
{
    private const FALLBACK = "I'm sorry, but I couldn't find an answer to your question in our public information. Please reach out to our support team directly for further assistance.";

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'services.openrouter.key' => 'test-api-key',
            'services.openrouter.url' => 'https://openrouter.test/api/v1/chat/completions',
            'services.openrouter.model' => 'test-model',
        ]);
    }

    public function test_question_outside_public_information_is_sent_with_strict_fallback_rule(): void
    {
        Http::fake([
            'openrouter.test/*' => Http::response([
                'choices' => [
                    ['message' => ['content' => self::FALLBACK]],
                ],
            ]),
        ]);

        $this->postJson(route('website.chat'), [
            'message' => 'What is the weather tomorrow?',
        ])->assertOk()
            ->assertExactJson(['answer' => self::FALLBACK]);

        Http::assertSentCount(1);
    }

    public function test_faq_question_uses_faq_first_and_published_website_context(): void
    {
        Http::fake([
            'openrouter.test/*' => Http::response([
                'choices' => [
                    ['message' => ['content' => 'You need a birth certificate, applicant photo, and a certificate from the Tribal Chieftain.']],
                ],
            ]),
        ]);

        $this->postJson(route('website.chat'), [
            'message' => 'What documents are required for a COC application?',
        ])->assertOk()
            ->assertExactJson([
                'answer' => 'You need a birth certificate, applicant photo, and a certificate from the Tribal Chieftain.',
            ]);

        Http::assertSent(function (Request $request): bool {
            $payload = $request->data();
            $systemPrompt = $payload['messages'][0]['content'] ?? '';
            $faqPosition = strpos($systemPrompt, '[FAQ]');
            $websitePosition = strpos($systemPrompt, '[WEBSITE_CONTENT]');

            return $request->url() === 'https://openrouter.test/api/v1/chat/completions'
                && $request->hasHeader('Authorization', 'Bearer test-api-key')
                && ($payload['model'] ?? null) === 'test-model'
                && ($payload['temperature'] ?? null) === 0
                && ($payload['messages'][1]['content'] ?? null) === 'What documents are required for a COC application?'
                && substr_count($systemPrompt, 'Question: ') === 6
                && $faqPosition !== false
                && $websitePosition !== false
                && $faqPosition < $websitePosition
                && str_contains($systemPrompt, 'FAQ information has priority over WEBSITE_CONTENT')
                && str_contains($systemPrompt, 'What is the Certificate of Confirmation (COC)?')
                && str_contains($systemPrompt, 'Contact details and office hours')
                && str_contains($systemPrompt, self::FALLBACK);
        });
    }

    public function test_public_website_question_can_use_website_content(): void
    {
        Http::fake([
            'openrouter.test/*' => Http::response([
                'choices' => [
                    ['message' => ['content' => 'The office is located at 1st Floor, Old Capitol Building, Burgos Ave., Cabanatuan City, 3100 Nueva Ecija, Philippines.']],
                ],
            ]),
        ]);

        $this->postJson(route('website.chat'), [
            'message' => 'Where is the provincial office?',
        ])->assertOk()
            ->assertJsonPath('answer', 'The office is located at 1st Floor, Old Capitol Building, Burgos Ave., Cabanatuan City, 3100 Nueva Ecija, Philippines.');

        Http::assertSentCount(1);
    }

    public function test_informal_ncip_identity_question_uses_published_website_definition(): void
    {
        $answer = 'NCIP means National Commission on Indigenous Peoples. Its Nueva Ecija Provincial Office serves as the provincial center for programs and services dedicated to Indigenous Cultural Communities and Indigenous Peoples throughout the province.';

        Http::fake([
            'openrouter.test/*' => Http::response([
                'choices' => [
                    ['message' => ['content' => $answer]],
                ],
            ]),
        ]);

        $this->postJson(route('website.chat'), [
            'message' => 'whats ncip',
        ])->assertOk()
            ->assertExactJson(['answer' => $answer]);

        Http::assertSent(function (Request $request): bool {
            $payload = $request->data();
            $systemPrompt = $payload['messages'][0]['content'] ?? '';

            return ($payload['messages'][1]['content'] ?? null) === 'whats ncip'
                && str_contains($systemPrompt, 'NCIP identity and provincial office')
                && str_contains($systemPrompt, 'NCIP means National Commission on Indigenous Peoples');
        });
    }

    public function test_prompt_contains_the_main_website_question_families(): void
    {
        Http::fake([
            'openrouter.test/*' => Http::response([
                'choices' => [
                    ['message' => ['content' => 'The requested public information is available on the website.']],
                ],
            ]),
        ]);

        $this->postJson(route('website.chat'), [
            'message' => 'how do i apply and where can i contact you?',
        ])->assertOk();

        Http::assertSent(function (Request $request): bool {
            $payload = $request->data();
            $systemPrompt = $payload['messages'][0]['content'] ?? '';

            foreach ([
                'RA 8371 and NCIP mandate',
                'ICCs/IPs rights framework',
                'Programs, projects, and services',
                'Contact details and office hours',
                'Certificate of Confirmation purpose and application',
                'COC uploads and genealogy form',
                'COC drafts, reuse, status, and resubmission',
                'Applicant registration and password recovery',
                'Public website navigation',
            ] as $topic) {
                if (! str_contains($systemPrompt, $topic)) {
                    return false;
                }
            }

            return str_contains($systemPrompt, 'Interpret common contractions, misspellings, informal grammar, short keyword searches, and paraphrases')
                && str_contains($systemPrompt, 'public navigation questions')
                && str_contains($systemPrompt, self::FALLBACK);
        });
    }

    public function test_prompt_preserves_dynamic_record_boundaries(): void
    {
        Http::fake([
            'openrouter.test/*' => Http::response([
                'choices' => [
                    ['message' => ['content' => self::FALLBACK]],
                ],
            ]),
        ]);

        $this->postJson(route('website.chat'), [
            'message' => 'which tribe was added today?',
        ])->assertOk()
            ->assertExactJson(['answer' => self::FALLBACK]);

        Http::assertSent(function (Request $request): bool {
            $payload = $request->data();
            $systemPrompt = $payload['messages'][0]['content'] ?? '';

            return str_contains($systemPrompt, 'Dynamic public records')
                && str_contains($systemPrompt, 'current recognized tribes, accomplishments, partners, or news records')
                && str_contains($systemPrompt, 'these records can change');
        });
    }

    public function test_provider_failure_returns_fallback(): void
    {
        Http::fake([
            'openrouter.test/*' => Http::response(['error' => 'Unavailable'], 503),
        ]);

        $this->postJson(route('website.chat'), [
            'message' => 'How long does COC processing take?',
        ])->assertStatus(503)
            ->assertExactJson(['answer' => self::FALLBACK]);
    }

    public function test_empty_provider_answer_is_replaced_with_fallback(): void
    {
        Http::fake([
            'openrouter.test/*' => Http::response([
                'choices' => [
                    ['message' => ['content' => '   ']],
                ],
            ]),
        ]);

        $this->postJson(route('website.chat'), [
            'message' => 'How can I track my COC application status?',
        ])->assertOk()
            ->assertExactJson(['answer' => self::FALLBACK]);
    }

    public function test_disallowed_source_phrase_is_replaced_with_fallback(): void
    {
        Http::fake([
            'openrouter.test/*' => Http::response([
                'choices' => [
                    ['message' => ['content' => 'According to the FAQ, processing takes a few working days.']],
                ],
            ]),
        ]);

        $this->postJson(route('website.chat'), [
            'message' => 'How long does processing take?',
        ])->assertOk()
            ->assertExactJson(['answer' => self::FALLBACK]);
    }

    public function test_message_must_not_exceed_500_characters(): void
    {
        Http::fake();

        $this->postJson(route('website.chat'), [
            'message' => str_repeat('a', 501),
        ])->assertUnprocessable()
            ->assertJsonValidationErrors('message');

        Http::assertNothingSent();
    }

    public function test_prompt_instructs_chatbot_to_respond_in_users_language(): void
    {
        $answerInTagalog = 'Kailangan mo ng birth certificate, 2x2 ID photo ng aplikante, at sertipiko mula sa Tribal Chieftain.';

        Http::fake([
            'openrouter.test/*' => Http::response([
                'choices' => [
                    ['message' => ['content' => $answerInTagalog]],
                ],
            ]),
        ]);

        $this->postJson(route('website.chat'), [
            'message' => 'Ano ang mga kailangan para sa COC?',
        ])->assertOk()
            ->assertExactJson(['answer' => $answerInTagalog]);

        Http::assertSent(function (Request $request): bool {
            $payload = $request->data();
            $systemPrompt = $payload['messages'][0]['content'] ?? '';

            return ($payload['messages'][1]['content'] ?? null) === 'Ano ang mga kailangan para sa COC?'
                && str_contains($systemPrompt, 'Respond in the same language or dialect used by the user in their message');
        });
    }

    public function test_localized_disallowed_source_phrase_is_replaced_with_fallback(): void
    {
        Http::fake([
            'openrouter.test/*' => Http::response([
                'choices' => [
                    ['message' => ['content' => 'Ayon sa FAQ, ang pagproseso ay tumatagal ng ilang araw.']],
                ],
            ]),
        ]);

        $this->postJson(route('website.chat'), [
            'message' => 'Gaano katagal ang pagproseso?',
        ])->assertOk()
            ->assertExactJson(['answer' => self::FALLBACK]);
    }
}
