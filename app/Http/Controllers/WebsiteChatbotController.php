<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class WebsiteChatbotController extends Controller
{
    private const FALLBACK_EN = "I'm sorry, but I couldn't find an answer to your question in our public information. For direct inquiries, you may reach our NCIP Nueva Ecija Provincial Office at (044) 979-2365, mobile +63 912 345 6789, or email ncip.nuevaecija@gmail.com.";
    private const FALLBACK_TL = "Paumanhin, ngunit hindi ko mahanap ang tiyak na sagot sa iyong katanungan sa aming pampublikong impormasyon. Para sa direktang pagtatanong, maaari kang makipag-ugnayan sa NCIP Nueva Ecija Provincial Office sa (044) 979-2365, mobile +63 912 345 6789, o email ncip.nuevaecija@gmail.com.";

    public function respond(Request $request)
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:1000'],
        ]);

        $message = trim($validated['message']);
        $isTagalog = $this->isTagalog($message);

        // 1. Check conversational pleasantries (greetings, thank you, identity) first for instant response
        $greetingResponse = $this->matchConversationalIntent($message, $isTagalog);
        if ($greetingResponse !== null) {
            return response()->json([
                'answer' => $greetingResponse,
                'source' => 'conversational',
            ]);
        }

        // 2. Attempt AI provider if configured (Gemini, Groq, OpenRouter, OpenAI, etc.)
        $aiAnswer = $this->tryAiProviders($message);
        if ($aiAnswer !== null && ! $this->looksUngrounded($aiAnswer)) {
            return response()->json([
                'answer' => $aiAnswer,
                'source' => 'ai',
            ]);
        }

        // 3. Fallback to intelligent local knowledge & FAQ matcher in matching language (English / Tagalog)
        $localAnswer = $this->matchLocalKnowledge($message, $isTagalog);
        if ($localAnswer !== null) {
            return response()->json([
                'answer' => $localAnswer,
                'source' => 'knowledge_base',
            ]);
        }

        // 4. Default helpful fallback in the appropriate language
        return response()->json([
            'answer' => $isTagalog ? self::FALLBACK_TL : self::FALLBACK_EN,
            'source' => 'fallback',
        ]);
    }

    /**
     * Detect if a user message is in Tagalog/Filipino or English.
     */
    private function isTagalog(string $message): bool
    {
        $clean = mb_strtolower(trim($message));
        $clean = preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $clean);
        $clean = preg_replace('/\s+/', ' ', $clean);

        // Tagalog question words, pronouns, particles, and common keywords
        $tagalogPatterns = [
            '/\b(ano|ano-ano|anu-ano|paano|pa\'no|pano|saan|nasaan|asan|kailan|kelan|bakit|magkano|gaano|sino|alin)\b/u',
            '/\b(ba|po|opo|ho|oho|nga|naman|kasi|pala|kaya|yata|tuloy|muna|pa|na|din|rin|daw|raw)\b/u',
            '/\b(ng|mga|sa|kay|kina|ni|nina|si|sila|nila|kanila|kanilang|ako|ko|akin|aking|ikaw|ka|mo|iyo|iyong|kami|namin|amin|aming|tayo|natin|atin|ating|siya|niya|kanya|kanyang)\b/u',
            '/\b(may|meron|wala|walang|kailangan|kailangang|dalhin|kumuha|mag-apply|magapply|pag-apply|bayad|oras|araw|opisina|bukas|sarado|salamat|maraming salamat|kamusta|kumusta|magandang|umaga|hapon|gabi|tanghali|angkan|pamilya|lahi|katutubo|katutubong|pamayanan|binalik|tanggap|makukuha|matatagpuan|tumawag|tanong|sagot|alamin|pwede|puwede|pede|libre|presyo|ayusin|dokumento|puno)\b/u',
            '/\b(mag|nag|pag)[a-z]{3,}\b/u',
        ];

        foreach ($tagalogPatterns as $pattern) {
            if (preg_match($pattern, $clean)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Try external AI providers in priority order.
     */
    private function tryAiProviders(string $message): ?string
    {
        // 1. Google Gemini
        $geminiKey = config('services.gemini.key');
        if (! empty($geminiKey)) {
            $answer = $this->callGemini($message, $geminiKey);
            if ($answer !== null) {
                return $answer;
            }
        }

        // 2. Groq
        $groqKey = config('services.groq.key');
        if (! empty($groqKey)) {
            $answer = $this->callOpenAiCompatible(
                $message,
                (string) config('services.groq.url', 'https://api.groq.com/openai/v1/chat/completions'),
                $groqKey,
                (string) config('services.groq.model', 'llama-3.3-70b-versatile')
            );
            if ($answer !== null) {
                return $answer;
            }
        }

        // 3. OpenRouter
        $openrouterKey = config('services.openrouter.key');
        if (! empty($openrouterKey)) {
            $answer = $this->callOpenAiCompatible(
                $message,
                (string) config('services.openrouter.url', 'https://openrouter.ai/api/v1/chat/completions'),
                $openrouterKey,
                (string) config('services.openrouter.model', 'meta-llama/llama-3.3-70b-instruct:free')
            );
            if ($answer !== null) {
                return $answer;
            }
        }

        // 4. OpenAI
        $openaiKey = config('services.openai.key');
        if (! empty($openaiKey)) {
            $answer = $this->callOpenAiCompatible(
                $message,
                (string) config('services.openai.url', 'https://api.openai.com/v1/chat/completions'),
                $openaiKey,
                (string) config('services.openai.model', 'gpt-4o-mini')
            );
            if ($answer !== null) {
                return $answer;
            }
        }

        // 5. Custom OpenAI-Compatible
        $compatibleKey = config('services.openai_compatible.key');
        $compatibleUrl = config('services.openai_compatible.url');
        if (! empty($compatibleKey) && ! empty($compatibleUrl)) {
            $answer = $this->callOpenAiCompatible(
                $message,
                (string) $compatibleUrl,
                $compatibleKey,
                (string) config('services.openai_compatible.model', 'gpt-5.6-sol')
            );
            if ($answer !== null) {
                return $answer;
            }
        }

        return null;
    }

    /**
     * Call Google Gemini REST API.
     */
    private function callGemini(string $message, string $apiKey): ?string
    {
        $model = config('services.gemini.model', 'gemini-1.5-flash');
        $endpoint = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

        $systemPrompt = $this->buildSystemPrompt();

        try {
            $response = Http::acceptJson()
                ->connectTimeout(2)
                ->timeout(4)
                ->post($endpoint, [
                    'system_instruction' => [
                        'parts' => [
                            ['text' => $systemPrompt],
                        ],
                    ],
                    'contents' => [
                        [
                            'role' => 'user',
                            'parts' => [
                                ['text' => $message],
                            ],
                        ],
                    ],
                    'generationConfig' => [
                        'temperature' => 0.2,
                        'maxOutputTokens' => 450,
                    ],
                ]);

            if ($response->successful()) {
                $text = (string) $response->json('candidates.0.content.parts.0.text');
                $text = trim($text);
                return $text !== '' ? $text : null;
            }
        } catch (Throwable $e) {
            Log::warning('Gemini API request failed: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Call OpenAI / OpenRouter / Groq / OpenAI-compatible chat completion endpoint.
     */
    private function callOpenAiCompatible(string $message, string $endpoint, string $apiKey, string $model): ?string
    {
        if ($endpoint !== '' && ! str_contains($endpoint, 'chat/completions')) {
            $endpoint = rtrim($endpoint, '/') . '/chat/completions';
        }

        $systemPrompt = $this->buildSystemPrompt();

        $headers = [
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        // If OpenRouter, add site metadata
        if (str_contains($endpoint, 'openrouter.ai')) {
            $headers['HTTP-Referer'] = config('app.url', 'http://localhost');
            $headers['X-Title'] = 'NCIP Nueva Ecija Public Assistant';
        }

        try {
            $response = Http::withHeaders($headers)
                ->acceptJson()
                ->connectTimeout(2)
                ->timeout(4)
                ->post($endpoint, [
                    'model' => $model,
                    'temperature' => 0.2,
                    'max_tokens' => 450,
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => $systemPrompt,
                        ],
                        [
                            'role' => 'user',
                            'content' => $message,
                        ],
                    ],
                ]);

            if ($response->successful()) {
                $text = (string) $response->json('choices.0.message.content');
                $text = trim($text);
                return $text !== '' ? $text : null;
            } else {
                Log::warning("AI Provider [{$endpoint}] responded with status {$response->status()}: " . substr($response->body(), 0, 200));
            }
        } catch (Throwable $e) {
            Log::warning("AI Provider [{$endpoint}] call failed: " . $e->getMessage());
        }

        return null;
    }

    /**
     * Build the knowledge-grounded system prompt for LLMs.
     */
    private function buildSystemPrompt(): string
    {
        $faqContext = collect($this->faqs())
            ->map(fn (array $faq) => "Question: {$faq['question']}\nAnswer: {$faq['answer']}")
            ->implode("\n\n");

        $websiteContext = collect($this->websiteContent())
            ->map(fn (array $item) => "Topic: {$item['topic']}\nInformation: {$item['information']}")
            ->implode("\n\n");

        return "You are the official NCIP Nueva Ecija virtual support assistant.\n"
            . "Answer accurately based ONLY on the facts stated in the context below. The context is verified public information about NCIP Nueva Ecija.\n"
            . "FAQ information has priority over general website content.\n"
            . "Respond in the SAME language or dialect used by the user (if user asks in Tagalog/Filipino, respond in Tagalog; if in English, respond in English).\n"
            . "Keep responses clear, helpful, professional, well-formatted, and concise.\n"
            . "Use markdown bullet points and bolding where helpful for readability.\n"
            . "If the context does not contain the answer, politely state that you do not have that specific information and provide our office contact details in the user's language.\n\n"
            . "[FAQ]\n{$faqContext}\n\n[WEBSITE_CONTENT]\n{$websiteContext}";
    }

    /**
     * Quick conversational intent matcher (greetings, thanks, bot identity).
     */
    private function matchConversationalIntent(string $message, bool $isTagalog): ?string
    {
        $clean = mb_strtolower(trim($message));
        $clean = preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $clean);
        $clean = preg_replace('/\s+/', ' ', $clean);

        // Greetings
        if (preg_match('/^(hi|hello|hey|kamusta|kumusta|mabuhay|good (morning|afternoon|evening|day)|magandang (araw|umaga|hapon|gabi)|test|uy|yo)\b/u', $clean)) {
            if ($isTagalog) {
                return "Magandang araw! 👋 Ako ang **NCIP Nueva Ecija Support Assistant**.\n\n"
                    . "Paano kita matutulungan ngayon? Maaari kang magtanong tungkol sa:\n"
                    . "• **Certificate of Confirmation (COC)** proseso at mga kailangang dokumento\n"
                    . "• **Genealogy Form** gabay at pagpirma ng Tribal Chieftain\n"
                    . "• **Bayad at Gaano Katagal** ang pagproseso ng aplikasyon\n"
                    . "• **Address ng Opisina, Oras ng Pagbubukas, at Contact Details**\n"
                    . "• **RA 8371 / IPRA** at mga programa ng NCIP para sa mga Katutubo";
            }
            return "Hello! 👋 I am the **NCIP Nueva Ecija Support Assistant**.\n\n"
                . "How can I help you today? You can ask me about:\n"
                . "• **Certificate of Confirmation (COC)** application process & requirements\n"
                . "• **Genealogy Form** guidelines & attestation\n"
                . "• **Fees & Processing Time**\n"
                . "• **Office Address, Hours & Contact Details**\n"
                . "• **RA 8371 / IPRA** and NCIP programs";
        }

        // Gratitude
        if (preg_match('/\b(thank you|thanks|salamat|maraming salamat|ty|thank u|salamat po)\b/u', $clean)) {
            if ($isTagalog) {
                return "Walang anuman po! Kung mayroon ka pang ibang katanungan tungkol sa mga serbisyo ng NCIP o sa iyong COC application, magtanong lamang anumang oras. Mag-ingat ka at magandang araw!";
            }
            return "You're very welcome! If you have any more questions regarding NCIP services or your COC application, feel free to ask anytime. Have a wonderful day!";
        }

        // Identity / capability
        if (preg_match('/\b(who are you|sino ka|what is your name|anong pangalan mo|what can you do|ano (ang )?pwede mo(ng)? itulong)\b/u', $clean)) {
            if ($isTagalog) {
                return "Ako ang opisyal na **NCIP Nueva Ecija Virtual Support Assistant**. Narito ako upang magbigay ng verified na impormasyon tungkol sa mga programa ng NCIP, Certificate of Confirmation (COC) online application, genealogy requirements, mga kailangang dokumento, oras ng opisina, at contact details.";
            }
            return "I am the official **NCIP Nueva Ecija Support Assistant**. I provide verified public information regarding NCIP programs, Certificate of Confirmation (COC) applications, genealogy requirements, office schedules, and contact details.";
        }

        return null;
    }

    /**
     * Smart local knowledge & FAQ matcher (works 100% offline with Tagalog & English support).
     */
    private function matchLocalKnowledge(string $message, bool $isTagalog): ?string
    {
        $clean = mb_strtolower(trim($message));
        $clean = preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $clean);
        $clean = preg_replace('/\s+/', ' ', $clean);

        // 1. Requirements (Check before generic COC)
        if (preg_match('/\b(requirement|requirements|kailangan|dokumento|documents needed|mga kailangan|dalhin|anu-ano ang kailangan|upload requirements)\b/u', $clean)) {
            if ($isTagalog) {
                return "📋 **Mga Kailangang Dokumento sa Pag-apply ng COC:**\n\n"
                    . "1. **Birth Certificate:** Kopya mula sa PSA o Local Civil Registrar (JPG/PNG/PDF hanggang 10MB).\n"
                    . "2. **Certificate of Tribal Membership:** Sertipikasyon mula sa iyong kinikilalang Tribal Chieftain / Katutubong Pinuno.\n"
                    . "3. **Genealogy Form:** I-download mula sa Step 4 ng online portal, punan ang impormasyon ng angkan, at papirmahan sa Council of Elders / Tribal Chieftain / Punong Barangay.\n"
                    . "4. **2x2 ID Photos:** 2 magkaparehong piraso na may puting background (i-upload at dalhin sa opisina kapag kukunin ang sertipiko).\n"
                    . "5. **Documentary Stamps:** Babayaran sa NCIP Provincial Office kapag kukunin na ang orihinal na sertipiko.";
            }
            return "📋 **Required Documents for COC Application:**\n\n"
                . "1. **Birth Certificate:** PSA or Local Civil Registrar copy (JPG/PNG/PDF up to 10MB).\n"
                . "2. **Certificate of Tribal Membership:** Issued by your recognized Tribal Chieftain / IP Leader.\n"
                . "3. **Genealogy Form:** Downloaded from the application portal, completed, and attested by the Council of Elders / Tribal Chieftain / Punong Barangay.\n"
                . "4. **2x2 ID Photos:** 2 identical copies on white background (uploaded and brought to the office upon claim).\n"
                . "5. **Documentary Stamps:** Paid at the provincial office upon release of the certificate.";
        }

        // 2. How to Apply / Application Steps
        if (preg_match('/\b(how to apply|paano mag apply|paano kumuha|how to request|paano mag request|step|steps|process|paraan|paano mag-apply|how to get coc|paano kumuha ng coc|application process|mag-apply)\b/u', $clean)) {
            if ($isTagalog) {
                return "📝 **Paraan ng Pag-apply ng COC Online:**\n\n"
                    . "1. **Mag-rehistro o Mag-login:** Gumawa ng account sa ating website at mag-login sa iyong applicant dashboard.\n"
                    . "2. **Punan ang COC Form:** Pindutin ang **\"Apply for COC\"**, piliin ang layunin (purpose), at punan ang personal, educational, at genealogy information.\n"
                    . "3. **I-download ang Genealogy Form:** I-print ang form mula sa Step 4 at papirmahan sa iyong Tribal Chieftain o Council of Elders.\n"
                    . "4. **I-upload ang mga Dokumento:** I-upload ang iyong ID Photo, Tribal Certificate, at pirmadong Genealogy Form.\n"
                    . "5. **Suriin at I-submit:** Silipin ang preview ng application at i-submit para masuri ng NCIP staff at maaprubahan ng Admin.\n\n"
                    . "Maaari mong subaybayan ang estado ng iyong aplikasyon sa **\"My COC History\"** sa dashboard.";
            }
            return "📝 **How to Apply for a Certificate of Confirmation (COC) Online:**\n\n"
                . "1. **Register / Log In:** Create an applicant account on our website and log in to your dashboard.\n"
                . "2. **Fill out COC Form:** Click **\"Apply for COC\"**, select your specific purpose, and complete the personal, educational, and genealogy sections.\n"
                . "3. **Download Genealogy Form:** Print the form generated in Step 4 and have it signed/attested by your Tribal Chieftain or Council of Elders.\n"
                . "4. **Upload Documents:** Upload your ID Photo, Tribal Certificate, and signed Genealogy Form.\n"
                . "5. **Preview & Submit:** Review all details carefully before submitting for NCIP staff review and admin approval.\n\n"
                . "You can track the progress of your application in real-time under **\"My COC History\"**.";
        }

        // 3. Fees / Payment
        if (preg_match('/\b(fee|fees|bayad|magkano|libre|free|payment|magbayad|cost|presyo|babayaran)\b/u', $clean)) {
            if ($isTagalog) {
                return "💵 **Impormasyon sa Bayad:**\n\n"
                    . "• **Online Application & Submission:** **LIBRE / WALANG BAYAD** (Walang bayad ang pagsusumite ng aplikasyon sa website).\n"
                    . "• **Documentary Stamps:** Ang karaniwang bayad para sa documentary stamps ng gobyerno ay binabayaran lamang sa NCIP Provincial Office kapag ilalabas na ang orihinal na sertipiko ayon sa opisyal na patakaran.";
            }
            return "💵 **Fees & Payment Information:**\n\n"
                . "• **Online Application & Submission:** **FREE** (No charge for submitting online applications).\n"
                . "• **Documentary Stamps:** Standard government documentary stamps are paid at the NCIP Provincial Office upon releasing the approved certificate in accordance with official regulations.";
        }

        // 4. Processing Time / Duration
        if (preg_match('/\b(how long|gaano katagal|duration|processing time|kailan makukuha|ilang araw|tagal|timeframe|release)\b/u', $clean)) {
            if ($isTagalog) {
                return "⏱️ **Gaano Katagal ang Pagproseso:**\n\n"
                    . "Karaniwang tumatagal ng ilang araw ng trabaho (working days) ang pagproseso matapos maipasa ang kumpleto at wastong mga dokumento. Nakasalalay ang bilis sa kalinawan ng mga dokumento at beripikasyon ng genealogy.\n\n"
                    . "Makakatanggap ka ng real-time notification sa iyong dashboard ukol sa estado ng iyong aplikasyon.";
            }
            return "⏱️ **Processing Time:**\n\n"
                . "Processing typically takes a few working days upon submission of complete and accurate documents. The turnaround time depends on the completeness of your uploaded files and genealogy verification.\n\n"
                . "You will receive real-time notifications on your applicant dashboard regarding status updates.";
        }

        // 5. What is NCIP / Meaning
        if (preg_match('/\b(what is ncip|whats ncip|what\'s ncip|ano ang ncip|meaning of ncip|ncip meaning|kahulugan ng ncip|ano ibig sabihin ng ncip|tungkol sa ncip|about ncip|who is ncip)\b/u', $clean)
            || ($clean === 'ncip' || $clean === 'what ncip' || $clean === 'whats ncip')) {
            if ($isTagalog) {
                return "🏛️ **National Commission on Indigenous Peoples (NCIP)**\n\n"
                    . "Ang **NCIP** (Pambansang Komisyon sa mga Katutubong Pamayanan) ay ang pangunahing ahensya ng pamahalaan sa Pilipinas na may mandatong kilalanin, protektahan, at itaguyod ang mga karapatan at kapakanan ng mga **Katutubong Pamayanan / Indigenous Peoples (ICCs/IPs)**.\n\n"
                    . "• **Batas na Pinagbatayan:** Itinatag sa bisa ng **Republic Act No. 8371** (Indigenous Peoples' Rights Act of 1997 o IPRA).\n"
                    . "• **NCIP Nueva Ecija Provincial Office:** Matatagpuan sa 1st Floor, Old Capitol Building, Burgos Ave., Cabanatuan City, na nagsisilbing sentro ng mga programa, pag-isyu ng Certificate of Confirmation (COC), tulong sa CADT/CALT, at mga serbisyo para sa mga katutubo sa buong lalawigan.";
            }
            return "🏛️ **National Commission on Indigenous Peoples (NCIP)**\n\n"
                . "The **NCIP** is the primary government agency in the Philippines responsible for formulating and implementing policies, plans, and programs to recognize, protect, and promote the rights and well-being of **Indigenous Cultural Communities / Indigenous Peoples (ICCs/IPs)**.\n\n"
                . "• **Legal Basis:** Created pursuant to **Republic Act No. 8371** (Indigenous Peoples' Rights Act of 1997 / IPRA).\n"
                . "• **NCIP Nueva Ecija Provincial Office:** Located at 1st Floor, Old Capitol Building, Burgos Ave., Cabanatuan City, serving as the provincial hub for ICCs/IPs programs, Certificate of Confirmation (COC) issuance, CADT/CALT assistance, and community welfare.";
        }

        // 6. What is COC / Purpose
        if (preg_match('/\b(what is coc|ano ang coc|what is certificate of confirmation|kahulugan ng coc|meaning of coc|para saan ang coc|purpose of coc|san gagamitin ang coc|ano ang silbi)\b/u', $clean)
            || (str_contains($clean, 'coc') && (str_contains($clean, 'what') || str_contains($clean, 'ano') || str_contains($clean, 'definition') || str_contains($clean, 'meaning')))) {
            if ($isTagalog) {
                return "📄 **Certificate of Confirmation (COC)**\n\n"
                    . "Ang **Certificate of Confirmation (COC)** ay isang opisyal na dokumentong inilalabas ng National Commission on Indigenous Peoples (NCIP) na nagpapatunay sa pagiging lehitimong miyembro ng isang indibidwal sa isang Katutubong Pamayanan o Indigenous Peoples (ICC/IP) group.\n\n"
                    . "**Pangunahing Gamit:**\n"
                    . "• Katibayan para sa scholarship grants at tulong-pinansyal sa pag-aaral\n"
                    . "• Pribilehiyo sa trabaho at Civil Service Commission (CSC)\n"
                    . "• Age qualification waivers para sa aplikasyon sa BJMP, BFP, BuCor, PNP, at AFP\n"
                    . "• Usapin sa Lupang Ninuno (Ancestral Domains) at representasyon sa IPMR";
            }
            return "📄 **Certificate of Confirmation (COC)**\n\n"
                . "The **Certificate of Confirmation (COC)** is an official document issued by the National Commission on Indigenous Peoples (NCIP) verifying an individual's recognized membership in an Indigenous Cultural Community or Indigenous Peoples (ICC/IP) group.\n\n"
                . "**Main Purposes:**\n"
                . "• Scholarship grants & educational assistance\n"
                . "• Local employment & Civil Service Commission (CSC) privileges\n"
                . "• Age qualification waivers for BJMP, BFP, BuCor, PNP, and AFP\n"
                . "• Ancestral land matters & IPMR representation";
        }

        // 7. Application Status & Tracking
        if (preg_match('/\b(status|approved|approval|pending|paano malaman|track|subaybayan|resulta|notification|history)\b/u', $clean)) {
            if ($isTagalog) {
                return "🔔 **Pagsusuri ng Estado ng Aplikasyon (Status):**\n\n"
                    . "Maaari mong suriin ang status ng iyong aplikasyon anumang oras sa iyong dashboard sa ilalim ng **\"My COC History\"**:\n"
                    . "• **Under Review / Pending:** Sinusuri ng NCIP staff ang iyong mga impormasyon at dokumento.\n"
                    . "• **Admin Approval:** Forwarded na sa Provincial Officer para sa pinal na pag-apruba.\n"
                    . "• **Approved:** Aprubado na! Handa na para sa pag-isyu ng opisyal na sertipiko.\n"
                    . "• **Returned / Rejected:** May kailangang itama o kulang. Basahin ang evaluator remarks.";
            }
            return "🔔 **Checking Application Status:**\n\n"
                . "You can view your application status anytime by logging into your account and visiting **\"My COC History\"**:\n"
                . "• **Under Review / Pending:** NCIP staff is evaluating your details and documents.\n"
                . "• **Admin Approval:** Forwarded to the Provincial Officer for final approval.\n"
                . "• **Approved:** Application approved! Ready for certificate issuance.\n"
                . "• **Returned / Rejected:** Corrections needed. Check the reviewer remarks for instructions.";
        }

        // 8. Returned / Rejected Application
        if (preg_match('/\b(reject|rejected|returned|binalik|na-reject|bakit na reject|remarks|paano kung na-reject|correction|edit|ayusin|resubmit)\b/u', $clean)) {
            if ($isTagalog) {
                return "⚠️ **Kung ang iyong Aplikasyon ay Naibalik (Returned) o Na-reject:**\n\n"
                    . "1. Mag-login sa iyong **Applicant Dashboard** at buksan ang **\"My COC History\"**.\n"
                    . "2. Basahin ang partikular na **remarks at feedback** mula sa NCIP evaluator upang malaman ang dapat itama.\n"
                    . "3. Pindutin ang **\"Edit/Resubmit\"** sa naturang aplikasyon.\n"
                    . "4. Itama ang mga impormasyon o mag-upload muli ng malinaw na dokumento ayon sa remarks.\n"
                    . "5. I-submit muli para sa panibagong review.";
            }
            return "⚠️ **If Your Application is Returned or Rejected:**\n\n"
                . "1. Go to your **Applicant Dashboard** and open **\"My COC History\"**.\n"
                . "2. Review the specific **remarks and feedback** provided by the NCIP evaluator.\n"
                . "3. Click **\"Edit/Resubmit\"** on the application.\n"
                . "4. Correct the designated fields or re-upload clear, updated documents as requested.\n"
                . "5. Resubmit for another evaluation.";
        }

        // 9. Office Hours / Schedule
        if (preg_match('/\b(hours|office hours|schedule|oras|bukas|araw|operating hours|open|kailan bukas|time)\b/u', $clean)) {
            if ($isTagalog) {
                return "🕒 **Oras ng Pagbubukas ng NCIP Nueva Ecija Office:**\n\n"
                    . "• **Lunes hanggang Biyernes:** 8:00 AM – 5:00 PM\n"
                    . "• **Sabado:** 8:00 AM – 12:00 PM (Tanghali)\n"
                    . "• **Linggo at Opisyal na Piyesta Opisyal:** Sarado";
            }
            return "🕒 **NCIP Nueva Ecija Office Hours:**\n\n"
                . "• **Monday to Friday:** 8:00 AM – 5:00 PM\n"
                . "• **Saturday:** 8:00 AM – 12:00 PM (Noon)\n"
                . "• **Sunday & Holidays:** Closed";
        }

        // 10. Office Location / Address
        if (preg_match('/\b(location|address|saan|nasaan|office|opisina|saan matatagpuan|building|cabanatuan|place|direksyon)\b/u', $clean)) {
            if ($isTagalog) {
                return "📍 **Lokasyon ng NCIP Nueva Ecija Provincial Office:**\n\n"
                    . "1st Floor, Old Capitol Building,\n"
                    . "Burgos Avenue, Cabanatuan City,\n"
                    . "3100 Nueva Ecija, Philippines.\n\n"
                    . "**Palatandaan:** Malapit sa Cabanatuan City Plaza / Old Capitol grounds.";
            }
            return "📍 **NCIP Nueva Ecija Provincial Office Address:**\n\n"
                . "1st Floor, Old Capitol Building,\n"
                . "Burgos Avenue, Cabanatuan City,\n"
                . "3100 Nueva Ecija, Philippines.\n\n"
                . "**Landmark:** Near Cabanatuan City Plaza / Old Capitol grounds.";
        }

        // 11. Contact Details / Phone / Email
        if (preg_match('/\b(contact|phone|telephone|telepono|cellphone|mobile|email|gmail|tumawag|reach|inquiry|hotline)\b/u', $clean)) {
            if ($isTagalog) {
                return "📞 **Impormasyon sa Pakikipag-ugnayan ng NCIP Nueva Ecija:**\n\n"
                    . "• **Telepono (Landline):** (044) 979-2365\n"
                    . "• **Mobile Number:** +63 912 345 6789\n"
                    . "• **Email:** ncip.nuevaecija@gmail.com / info.ncipne@gov.ph\n"
                    . "• **Address:** 1st Floor, Old Capitol Bldg., Burgos Ave., Cabanatuan City";
            }
            return "📞 **NCIP Nueva Ecija Contact Information:**\n\n"
                . "• **Telephone:** (044) 979-2365\n"
                . "• **Mobile:** +63 912 345 6789\n"
                . "• **Email:** ncip.nuevaecija@gmail.com / info.ncipne@gov.ph\n"
                . "• **Address:** 1st Floor, Old Capitol Bldg., Burgos Ave., Cabanatuan City";
        }

        // 12. Genealogy Form Guidelines
        if (preg_match('/\b(genealogy|geneology|puno ng pamilya|angkan|great grand|magulang|lolo|lola|chieftain signature|elders)\b/u', $clean)) {
            if ($isTagalog) {
                return "🌳 **Gabay sa Genealogy Form:**\n\n"
                    . "• Ipinapakita nito ang iyong lahi at pinagmulang katutubong angkan (Magulang, Lolo at Lola, at Great-Grandparents).\n"
                    . "• **Hakbang 1:** I-download at i-print ang Genealogy Form mula sa **Step 4** ng online application.\n"
                    . "• **Hakbang 2:** Papirmahan at patunayan ito sa iyong **Council of Elders / Tribal Chieftain / Punong Barangay**.\n"
                    . "• **Hakbang 3:** Kunan ng malinaw na scan o litrato ang pirmadong form.\n"
                    . "• **Hakbang 4:** I-upload sa portal sa format na PDF, JPG, o PNG (hanggang 10MB).";
            }
            return "🌳 **Genealogy Form Guidelines:**\n\n"
                . "• Traces your ancestral lineage (Parents, Grandparents, and Great-Grandparents).\n"
                . "• **Step 1:** Download and print the Genealogy Form from **Step 4** of the COC application.\n"
                . "• **Step 2:** Have it attested and signed by your **Council of Elders / Tribal Chieftain / Punong Barangay**.\n"
                . "• **Step 3:** Scan or take a clear photo of the signed form.\n"
                . "• **Step 4:** Upload the file in PDF, JPG, or PNG format (up to 10MB).";
        }

        // 13. RA 8371 / IPRA / Mandate / Rights
        if (preg_match('/\b(ra 8371|ipra|republic act 8371|mandate|rights|karapatan|law|batas)\b/u', $clean)) {
            if ($isTagalog) {
                return "⚖️ **Republic Act No. 8371 (Indigenous Peoples' Rights Act of 1997 / IPRA):**\n\n"
                    . "Ang IPRA ay batas na kumikilala, nagpoprotekta, at nagtataguyod sa mga karapatan ng mga Katutubong Pamayanan (ICCs/IPs).\n\n"
                    . "**Apat (4) na Bungkos ng mga Karapatan (36 Partikular na Karapatan):**\n"
                    . "1. **Karapatan sa Lupang Ninuno (Ancestral Domains/Lands):** CADT at CALT\n"
                    . "2. **Karapatan sa Sariling Pamamahala (Self-Governance & Empowerment):** IPMR at mga tradisyunal na batas\n"
                    . "3. **Katarungang Panlipunan at Karapatang Pantao (Social Justice & Human Rights):** Pantay na serbisyo at proteksyon laban sa diskriminasyon\n"
                    . "4. **Karapatan sa Katutubong Kultura at Integridad (Cultural Integrity):** Pangangalaga sa tradisyon, wika, at FPIC";
            }
            return "⚖️ **Republic Act No. 8371 (IPRA of 1997):**\n\n"
                . "The Indigenous Peoples' Rights Act recognizes, protects, and promotes the rights of Indigenous Cultural Communities / Indigenous Peoples (ICCs/IPs).\n\n"
                . "**4 Fundamental Bundles of Rights (36 Specific Rights):**\n"
                . "1. **Rights to Ancestral Domains/Lands** (CADT & CALT)\n"
                . "2. **Rights to Self-Governance & Empowerment** (IPMR & customary laws)\n"
                . "3. **Social Justice & Human Rights** (Non-discrimination, basic services)\n"
                . "4. **Rights to Cultural Integrity** (Preservation of heritage, traditions, FPIC)";
        }

        // 14. I'M PART Partnership
        if (preg_match('/\b(i\'m part|im part|part|partnership|convergence)\b/u', $clean)) {
            if ($isTagalog) {
                return "🤝 **I'M PART (Inter-Agency / Indigenous Multi-Stakeholders Partnership):**\n\n"
                    . "Ang I'M PART ay isang panlalawigang Whole-of-Nation convergence sa Nueva Ecija na nagbubuklod sa mga ahensya ng gobyerno, pribadong sektor, civil society organizations, at mga Katutubong Pamayanan (ICCs/IPs).\n"
                    . "Binuo noong 2017 at opisyal na inilunsad noong Oktubre 29, 2021 upang mapalakas ang pagtutulungan para sa kabuhayan, edukasyon, at proteksyon ng mga katutubo.";
            }
            return "🤝 **I'M PART (Inter-Agency / Indigenous Multi-Stakeholders Partnership):**\n\n"
                . "I'M PART is a Provincial Whole-of-Nation Council/Convergence in Nueva Ecija uniting government agencies, the private sector, civil society organizations, and ICCs/IPs.\n"
                . "Conceptualized in 2017 and launched on October 29, 2021, it advances collaborative development, cultural protection, and socio-economic support for indigenous communities.";
        }

        // 15. Indigenous Groups / Tribes in Nueva Ecija
        if (preg_match('/\b(tribe|tribes|tribo|ethnic|ip groups|kalanguya|dumagat|bugkalot|ilongot|applangan)\b/u', $clean)) {
            if ($isTagalog) {
                return "🏔️ **Mga Kinikilalang Katutubong Pamayanan / Tribo sa Nueva Ecija:**\n\n"
                    . "Ang Nueva Ecija ay tahanan ng iba't ibang katutubong pamayanan, kabilang ang mga **Kalanguya**, **Bugkalot / Ilongot**, at **Dumagat**.\n\n"
                    . "Para sa kumpletong profiles at talaan ng mga tribo, bisitahin ang seksyong **\"Tribes\"** sa ating website o magtungo sa NCIP Provincial Office.";
            }
            return "🏔️ **Recognized ICCs / Tribes in Nueva Ecija:**\n\n"
                . "Nueva Ecija is home to vibrant indigenous communities, notably the **Kalanguya**, **Bugkalot / Ilongot**, and **Dumagat** peoples.\n\n"
                . "For comprehensive profiles and tribal listings, please visit the **\"Tribes\"** section on our website or visit the NCIP Provincial Office.";
        }

        // 16. Account, Registration, or Password Reset
        if (preg_match('/\b(password|forgot password|nakalimutan ang password|reset password|login|sign in|mag log in|register|gumawa ng account|account)\b/u', $clean)) {
            if ($isTagalog) {
                return "🔐 **Tulong sa Account at Password:**\n\n"
                    . "• **Nakalimutan ang Password:** Sa Login page, pindutin ang **\"Forgot Password?\"** at ilagay ang iyong rehistradong email upang makatanggap ng password reset link.\n"
                    . "• **Bagong Rehistro:** Pindutin ang **\"Register\"**, punan ang iyong profile information, at i-upload ang iyong Birth Certificate upang makagawa ng account.";
            }
            return "🔐 **Account & Password Assistance:**\n\n"
                . "• **Forgot Password:** On the Login page, click **\"Forgot Password?\"** and enter your email address to receive a secure password-reset link.\n"
                . "• **New Registration:** Click **\"Register\"**, fill out your profile details, and upload your Birth Certificate to create an account.";
        }

        // 17. Programs, Projects, and Services
        if (preg_match('/\b(program|programs|projects|services|cadt|calt|adsdpp|fpic|adjudication)\b/u', $clean)) {
            if ($isTagalog) {
                return "📁 **Mga Programa, Proyekto, at Serbisyo ng NCIP:**\n\n"
                    . "• **Ancestral Domain:** Pagtulong sa CADT / CALT facilitation, ADSDPP formulation, at ancestral land titling.\n"
                    . "• **Sariling Pamamahala:** FPIC (Free, Prior and Informed Consent) facilitation, MOA monitoring, at pagsasanay sa IPMR.\n"
                    . "• **Katarungang Panlipunan:** Libreng tulong legal, proteksyon sa karapatang pantao, at mga livelihood programs.\n"
                    . "• **Katutubong Kultura:** Pangangalaga sa kultura, dokumentasyon ng katutubong kaalaman at tradisyon (IKSP).";
            }
            return "📁 **NCIP Programs, Projects & Services:**\n\n"
                . "• **Ancestral Domain:** CADT / CALT facilitation, ADSDPP formulation, and ancestral land titling.\n"
                . "• **Self-Governance:** FPIC (Free, Prior and Informed Consent) facilitation, MOA monitoring, and IPMR capacity building.\n"
                . "• **Social Justice:** Legal assistance, human rights protection, and socio-economic livelihood programs.\n"
                . "• **Cultural Integrity:** Cultural preservation, documentation, and indigenous knowledge systems & practices (IKSP).";
        }

        return null;
    }

    private function faqs(): array
    {
        return [
            [
                'question' => 'What is NCIP?',
                'answer' => 'NCIP stands for the National Commission on Indigenous Peoples. It is the primary Philippine government agency mandated under Republic Act No. 8371 (Indigenous Peoples’ Rights Act of 1997 / IPRA) to protect and promote the rights, culture, ancestral domains, and well-being of Indigenous Cultural Communities and Indigenous Peoples (ICCs/IPs). The NCIP Nueva Ecija Provincial Office is located at the 1st Floor, Old Capitol Building, Burgos Ave., Cabanatuan City.',
            ],
            [
                'question' => 'What is the Certificate of Confirmation (COC)?',
                'answer' => "The Certificate of Confirmation (COC) is an official document issued by the National Commission on Indigenous Peoples (NCIP) that verifies a person's membership in an Indigenous Cultural Community or Indigenous Peoples (ICC/IP) group. It serves as proof of recognition and allows IPs to avail benefits and services from government programs.",
            ],
            [
                'question' => 'How can I request a COC online?',
                'answer' => 'You can request a COC by creating an account on the website, filling out the COC request form, and uploading the required documents: birth certificate, photo of the applicant, and certificate issued by the Tribal Chieftain. Once submitted, the NCIP staff will review your application before it is approved by the admin.',
            ],
            [
                'question' => 'How long does it take to process my COC request?',
                'answer' => 'Processing usually takes a few working days after submission. The exact duration depends on the completeness and accuracy of your uploaded documents.',
            ],
            [
                'question' => 'How will I know if my COC request is approved?',
                'answer' => 'You will receive a notification through your account about your application status (Pending, Approved, or Rejected). You can also track your request on your dashboard.',
            ],
            [
                'question' => 'What should I do if my application is rejected?',
                'answer' => 'If your application is rejected, you will receive feedback or remarks explaining the reason. You can edit or re-submit your documents for another review.',
            ],
            [
                'question' => 'Is there a fee for requesting a COC online?',
                'answer' => 'Currently, no fee is required for online submission. However, applicants may need to pay standard government processing fees upon approval, depending on NCIP regulations.',
            ],
        ];
    }

    private function websiteContent(): array
    {
        return [
            [
                'topic' => 'NCIP identity and provincial office',
                'information' => 'NCIP means National Commission on Indigenous Peoples. The NCIP Nueva Ecija Provincial Office is in Cabanatuan City, Nueva Ecija, and serves as the provincial center for programs and services for Indigenous Cultural Communities and Indigenous Peoples throughout the province.',
            ],
            [
                'topic' => 'RA 8371 and NCIP mandate',
                'information' => 'Republic Act No. 8371 is the Indigenous Peoples’ Rights Act of 1997. It safeguards the rights of Indigenous Peoples and Indigenous Cultural Communities in the Philippines, recognizes their distinct identities, cultures, and traditional territories, and provides a legal framework for recognition of their rights. The NCIP mandate is to protect and promote the interest and well-being of ICCs/IPs with due regard to their beliefs, customs, traditions, and institutions.',
            ],
            [
                'topic' => 'NCIP vision, mission, goals, and values',
                'information' => "The NCIP mission is to be a trusted partner and lead advocate of ICCs/IPs in upholding their rights and well-being under the Indigenous Peoples' Rights Act. The Nueva Ecija Provincial Office vision is to empower Indigenous Peoples to live in dignity and serve as a center for culture-based, peaceful, united, resilient, self-reliant, progressive, and sustainable ICCs in Nueva Ecija. Its goals include documenting ICC/IP history and conditions, establishing an IP Family Registry/data bank, empowering ICCs/IPs and staff, designing sustainable programs and services, and building partnerships. Its core values are Maka-Diyos, Maka-Tao, Makakalikasan at Makabansa.",
            ],
            [
                'topic' => 'ICCs/IPs rights framework',
                'information' => 'The ICC/IP rights framework is anchored on IPRA/RA 8371 and contains four fundamental bundles and 36 specific rights: Rights to Ancestral Domains/Lands; Rights to Self-Governance and Empowerment; Social Justice and Human Rights; and Rights to Cultural Integrity. These cover ancestral lands, waters and natural resources, community governance and participation, protection from historical injustices, and preservation and development of cultures and traditions.',
            ],
            [
                'topic' => 'Programs, projects, and services',
                'information' => 'The Programs, Projects and Services page presents four mandated programs and more than 20 sub-programs covering ancestral domains, self-governance and empowerment, social justice and human rights, and cultural integrity. Examples include CADT and CALT assistance, ADSDPP and CRDP assistance, FPIC processes and MOA facilitation, IP participation, adjudication, economic development, environmental protection, education and advocacy, emergency assistance, research, documentation, and cultural protection.',
            ],
            [
                'topic' => 'I’M PART partnership',
                'information' => "I’M PART means Inter-Agency/Indigenous Multi-Stakeholders Partnership. It is a Provincial Whole-of-Nation Council/Convergence in Nueva Ecija involving government, business and private sector, civil society organizations, and ICCs/IPs. It was conceptualized in 2017 and launched on October 29, 2021.",
            ],
            [
                'topic' => 'Public website navigation',
                'information' => 'Public website sections include About Us, ICCs/IPs Rights, Programs, Projects and Services, Accomplishments, Partnership, Contact Us, and News. The News section includes public news details, while Accomplishments, Tribes, and Partners pages contain current public records that may change over time.',
            ],
            [
                'topic' => 'Contact details and office hours',
                'information' => 'The NCIP Nueva Ecija Provincial Office is at 1st Floor, Old Capitol Building, Burgos Ave., Cabanatuan City, 3100 Nueva Ecija, Philippines. Telephone: (044) 979-2365. The public contact page displays mobile number +63 9123456789 and emails ncip.nuevaecija@gmail.com and info.ncipne@gov.ph. Office hours are Monday to Friday, 8:00 AM to 5:00 PM, and Saturday, 8:00 AM to 12:00 PM.',
            ],
            [
                'topic' => 'Certificate of Confirmation purpose and application',
                'information' => 'A Certificate of Confirmation (COC) is an official NCIP document that verifies a person’s membership in an ICC/IP group and serves as proof of recognition. Applicants create an account, select a purpose, complete the COC forms, upload required documents, preview the information, and submit the application for staff review and admin approval. Only one purpose should be selected for an application. Published purposes include Scholarship, Local Employment, Land Matter, Civil Service Commission, IPMR, Certificate of Tribal Marriage, Travel Abroad, NAPOLCOM Requirement, age waivers for BJMP, BuCor, BFP, and AFP, and Others.',
            ],
            [
                'topic' => 'COC forms and requirements',
                'information' => 'COC preparation includes the Information Index Form, Genealogy Form, Certification of IP Membership, two identical 2x2 ID photos brought to the office, two documentary stamps paid at the office, Birth Certificate, and certification from the Office of the Tribal Chieftain. Form steps collect location, purpose, personal, education, parent, grandparent, and great-grandparent genealogy information. Married applicants provide spouse information; single, widowed, or separated applicants use N/A for spouse fields.',
            ],
            [
                'topic' => 'COC uploads and genealogy form',
                'information' => 'The upload step requires an applicant picture in JPG, PNG, or JPEG up to 5 MB; a tribal certificate in JPG, PNG, JPEG, or PDF up to 10 MB; and a genealogy form in PDF, JPG, JPEG, or PNG up to 10 MB. The genealogy form is downloaded and printed from Step 4, attested by the Council of Elders, IP Leader, or Punong Barangay, signed over the printed name, completed, and then uploaded. Applicants review the preview before final submission.',
            ],
            [
                'topic' => 'COC drafts, reuse, status, and resubmission',
                'information' => 'Draft COC applications can be continued or reset. Applicants with an application under review must wait for approval or rejection before submitting another. Approved applicants may apply again using previous data, but must update the purpose and upload the required documents. The applicant dashboard and status page show statuses such as Under Review, Pending, Admin Approval, Returned, Approved, and Rejected. Returned applications show section remarks; applicants should correct the relevant information or documents and resubmit.',
            ],
            [
                'topic' => 'Applicant history and uploaded documents',
                'information' => 'My COC History shows application numbers, statuses, approved dates when applicable, and a Documents action. Applicants can view uploaded applicant photos, tribal certificates, and genealogy forms; missing documents are identified as not uploaded. The dashboard provides access to application status and documents.',
            ],
            [
                'topic' => 'Applicant registration and password recovery',
                'information' => 'Registration collects the applicant’s name, email, province, municipality, barangay, Indigenous Group/Tribe, contact information, elder/chieftain/leader, password, and birth certificate. Existing users can sign in. Password recovery requires an email address and sends a password-reset link; the page also links back to login.',
            ],
            [
                'topic' => 'Dynamic public records',
                'information' => 'For the current recognized tribes, accomplishments, partners, or news records, use the corresponding public website page because these records can change. The chatbot does not assume that a particular changing record is current unless it is directly included in the available public context.',
            ],
        ];
    }

    private function looksUngrounded(string $answer): bool
    {
        $normalized = strtolower($answer);

        return str_contains($normalized, 'according to the faq')
            || str_contains($normalized, 'based on the website context')
            || str_contains($normalized, 'as an ai language model')
            || str_contains($normalized, 'ayon sa faq')
            || str_contains($normalized, 'batay sa website context')
            || str_contains($normalized, 'bilang isang ai');
    }
}
