<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Translation;

class TranslationUnitTest extends TestCase
{
    public function test_translation_model_has_fillable_fields(): void
    {
        $translation = new Translation();

        $this->assertEquals([
            'locale', 'key', 'content', 'tags'
        ], $translation->getFillable());
    }

    public function test_translation_casts_tags_as_array(): void
    {
        $translation = Translation::factory()->make(['tags' => ['welcome', 'intro']]);

        $this->assertIsArray($translation->tags);
    }
}
