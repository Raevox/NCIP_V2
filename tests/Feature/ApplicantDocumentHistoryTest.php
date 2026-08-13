<?php

namespace Tests\Feature;

use App\Models\CocApplication;
use App\Models\IpAccount;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ApplicantDocumentHistoryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('ip_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('name')->default('');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('status')->default('active');
            $table->string('document_path')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('coc_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('ip_accounts')->cascadeOnDelete();
            $table->string('status')->default('Draft');
            $table->string('coc_status')->default('Under Review');
            $table->string('applicant_picture')->nullable();
            $table->string('tribal_certificate')->nullable();
            $table->string('genealogy_form')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('coc_applications');
        Schema::dropIfExists('ip_accounts');

        parent::tearDown();
    }

    public function test_applicant_can_view_documents_for_their_application(): void
    {
        $applicant = $this->createApplicant('owner@example.com');
        $application = $this->createCocApplication($applicant, [
            'tribal_certificate' => 'applications/certificates/tribal.pdf',
        ]);

        $response = $this->actingAs($applicant, 'applicant')
            ->get(route('applicant.history.documents', $application));

        $response->assertOk()
            ->assertSee('Application No.')
            ->assertSee('tribal.pdf')
            ->assertSee(route('applicant.history.documents.view', [$application, 'tribal_certificate']));
    }

    public function test_applicant_cannot_view_another_applicants_documents(): void
    {
        $owner = $this->createApplicant('owner@example.com');
        $otherApplicant = $this->createApplicant('other@example.com');
        $application = $this->createCocApplication($owner);

        $this->actingAs($otherApplicant, 'applicant')
            ->get(route('applicant.history.documents', $application))
            ->assertNotFound();

        $this->actingAs($otherApplicant, 'applicant')
            ->get(route('applicant.history.documents.view', [$application, 'tribal_certificate']))
            ->assertNotFound();
    }

    public function test_applicant_can_open_an_uploaded_document_inline(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('applications/genealogy/form.pdf', 'document contents');

        $applicant = $this->createApplicant('owner@example.com');
        $application = $this->createCocApplication($applicant, [
            'genealogy_form' => 'applications/genealogy/form.pdf',
        ]);

        $response = $this->actingAs($applicant, 'applicant')
            ->get(route('applicant.history.documents.view', [$application, 'genealogy_form']));

        $response->assertOk()
            ->assertHeader('content-disposition', 'inline; filename="form.pdf"')
            ->assertHeader('x-content-type-options', 'nosniff');
        $this->assertSame('document contents', $response->streamedContent());
    }

    public function test_missing_uploaded_document_returns_not_found(): void
    {
        Storage::fake('public');

        $applicant = $this->createApplicant('owner@example.com');
        $application = $this->createCocApplication($applicant);

        $this->actingAs($applicant, 'applicant')
            ->get(route('applicant.history.documents.view', [$application, 'genealogy_form']))
            ->assertNotFound();
    }

    private function createApplicant(string $email): IpAccount
    {
        return IpAccount::query()->create([
            'first_name' => 'Test',
            'last_name' => 'Applicant',
            'name' => 'Test Applicant',
            'email' => $email,
            'password' => bcrypt('password'),
            'status' => 'active',
        ]);
    }

    private function createCocApplication(IpAccount $applicant, array $attributes = []): CocApplication
    {
        return CocApplication::query()->create($attributes + [
            'user_id' => $applicant->id,
            'status' => 'Under Review',
            'coc_status' => 'Under Review',
        ]);
    }
}
