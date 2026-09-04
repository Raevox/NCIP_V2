<?php

namespace Tests\Unit;

use App\Models\CocApplication;
use PHPUnit\Framework\TestCase;

class CocApplicationDocumentReviewTest extends TestCase
{
    public function test_it_returns_only_documents_marked_for_correction(): void
    {
        $application = new CocApplication([
            'applicant_picture_status' => 'approved',
            'birth_certificate_status' => 'returned',
            'tribal_certificate_status' => 'approved',
            'genealogy_form_status' => 'returned',
        ]);

        $this->assertSame(
            ['birth_certificate', 'genealogy_form'],
            $application->getReturnedDocuments()
        );
    }
}
