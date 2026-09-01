<?php

namespace Tests\Feature;

use Tests\TestCase;

class WebsiteChatbotTest extends TestCase
{
    public function test_login_page_renders_with_chatbot()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('ncipChatbot');
        $response->assertSee('NCIP Support Assistant');
    }

    /* -------------------------------------------------------------
     * ENGLISH TESTS
     * ------------------------------------------------------------- */
    public function test_english_greeting()
    {
        $response = $this->postJson('/api/website-chat', ['message' => 'Hello there']);
        $response->assertStatus(200);
        $this->assertStringContainsString('How can I help you today?', $response->json('answer'));
    }

    public function test_english_whats_ncip()
    {
        $response = $this->postJson('/api/website-chat', ['message' => 'whats ncip']);
        $response->assertStatus(200);
        $this->assertStringContainsString('The **NCIP** is the primary government agency', $response->json('answer'));
    }

    public function test_english_whats_coc()
    {
        $response = $this->postJson('/api/website-chat', ['message' => 'what is coc?']);
        $response->assertStatus(200);
        $this->assertStringContainsString('The **Certificate of Confirmation (COC)** is an official document', $response->json('answer'));
    }

    public function test_english_requirements()
    {
        $response = $this->postJson('/api/website-chat', ['message' => 'what are the requirements for coc?']);
        $response->assertStatus(200);
        $this->assertStringContainsString('Required Documents for COC Application', $response->json('answer'));
    }

    public function test_english_how_to_apply()
    {
        $response = $this->postJson('/api/website-chat', ['message' => 'how to apply for coc online?']);
        $response->assertStatus(200);
        $this->assertStringContainsString('How to Apply for a Certificate of Confirmation', $response->json('answer'));
    }

    public function test_english_office_location()
    {
        $response = $this->postJson('/api/website-chat', ['message' => 'where is your office located?']);
        $response->assertStatus(200);
        $this->assertStringContainsString('NCIP Nueva Ecija Provincial Office Address', $response->json('answer'));
    }

    public function test_english_fees()
    {
        $response = $this->postJson('/api/website-chat', ['message' => 'is there a fee for applying?']);
        $response->assertStatus(200);
        $this->assertStringContainsString('Fees & Payment Information', $response->json('answer'));
    }

    /* -------------------------------------------------------------
     * TAGALOG TESTS
     * ------------------------------------------------------------- */
    public function test_tagalog_greeting()
    {
        $response = $this->postJson('/api/website-chat', ['message' => 'Magandang araw po']);
        $response->assertStatus(200);
        $this->assertStringContainsString('Paano kita matutulungan ngayon?', $response->json('answer'));
    }

    public function test_tagalog_whats_ncip()
    {
        $response = $this->postJson('/api/website-chat', ['message' => 'ano ang ncip?']);
        $response->assertStatus(200);
        $this->assertStringContainsString('Pambansang Komisyon sa mga Katutubong Pamayanan', $response->json('answer'));
    }

    public function test_tagalog_whats_coc()
    {
        $response = $this->postJson('/api/website-chat', ['message' => 'ano po ang coc?']);
        $response->assertStatus(200);
        $this->assertStringContainsString('ay isang opisyal na dokumentong inilalabas ng National Commission on Indigenous Peoples', $response->json('answer'));
    }

    public function test_tagalog_requirements()
    {
        $response = $this->postJson('/api/website-chat', ['message' => 'ano-ano ang mga kailangang dalhin para sa coc?']);
        $response->assertStatus(200);
        $this->assertStringContainsString('Mga Kailangang Dokumento sa Pag-apply ng COC', $response->json('answer'));
    }

    public function test_tagalog_how_to_apply()
    {
        $response = $this->postJson('/api/website-chat', ['message' => 'paano mag apply ng coc online?']);
        $response->assertStatus(200);
        $this->assertStringContainsString('Paraan ng Pag-apply ng COC Online', $response->json('answer'));
    }

    public function test_tagalog_office_location()
    {
        $response = $this->postJson('/api/website-chat', ['message' => 'saan ang opisina ninyo sa nueva ecija?']);
        $response->assertStatus(200);
        $this->assertStringContainsString('Lokasyon ng NCIP Nueva Ecija Provincial Office', $response->json('answer'));
    }

    public function test_tagalog_fees()
    {
        $response = $this->postJson('/api/website-chat', ['message' => 'may bayad ba ang pagkuha ng coc?']);
        $response->assertStatus(200);
        $this->assertStringContainsString('LIBRE / WALANG BAYAD', $response->json('answer'));
    }

    public function test_tagalog_gratitude()
    {
        $response = $this->postJson('/api/website-chat', ['message' => 'Maraming salamat po!']);
        $response->assertStatus(200);
        $this->assertStringContainsString('Walang anuman po!', $response->json('answer'));
    }
}
