<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\SubDistrict;
use App\CulturalHeritage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageCulturalHeritageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_see_cultural_heritage_list_in_cultural_heritage_index_page()
    {
        $subDistrict = factory(SubDistrict::class)->create();
        $culturalHeritage = factory(CulturalHeritage::class)->create([
            'sub_district_id' => $subDistrict->id,
        ]);

        $this->loginAsUser();
        $this->visitRoute('cultural_heritages.index');
        $this->see($culturalHeritage->name);
    }

    private function getCreateFields(array $overrides = [])
    {
        return array_merge([
            'name'            => 'Situs Cagar Budaya Gereja Imanuel Madomai',
            'type'            => 'Situs',
            'sub_district_id' => 1,
            'village'         => 'Saka Mangkahai',
            'description'     => 'CulturalHeritage 1 description',
        ], $overrides);
    }

    /** @test */
    public function user_can_create_a_cultural_heritage()
    {
        $this->loginAsUser();
        $subDistrict = factory(SubDistrict::class)->create();
        $this->visitRoute('cultural_heritages.index');

        $this->click(__('cultural_heritage.create'));
        $this->seeRouteIs('cultural_heritages.create');

        $this->submitForm(__('cultural_heritage.create'), $this->getCreateFields([
            'sub_district_id' => $subDistrict->id,
        ]));

        $this->seeRouteIs('cultural_heritages.show', CulturalHeritage::first());

        $this->seeText(__('cultural_heritage.created'));

        $this->seeInDatabase('cultural_heritages', $this->getCreateFields());
    }

    /** @test */
    public function validate_cultural_heritage_name_is_required()
    {
        $this->loginAsUser();

        // name empty
        $this->post(route('cultural_heritages.store'), $this->getCreateFields(['name' => '']));
        $this->assertSessionHasErrors('name');
    }

    /** @test */
    public function validate_cultural_heritage_name_is_not_more_than_60_characters()
    {
        $this->loginAsUser();

        // name 70 characters
        $this->post(route('cultural_heritages.store'), $this->getCreateFields([
            'name' => str_repeat('Test Title', 7),
        ]));
        $this->assertSessionHasErrors('name');
    }

    /** @test */
    public function validate_cultural_heritage_description_is_not_more_than_255_characters()
    {
        $this->loginAsUser();

        // description 256 characters
        $this->post(route('cultural_heritages.store'), $this->getCreateFields([
            'description' => str_repeat('Long description', 16),
        ]));
        $this->assertSessionHasErrors('description');
    }

    private function getEditFields(array $overrides = [])
    {
        return array_merge([
            'name'            => 'Situs Cagar Budaya Kuta Bataguh',
            'type'            => 'Situs',
            'sub_district_id' => 1,
            'village'         => 'Ds.Lunuk',
            'description'     => 'CulturalHeritage 1 description',
        ], $overrides);
    }

    /** @test */
    public function user_can_edit_a_cultural_heritage()
    {
        $this->loginAsUser();
        $subDistrict = factory(SubDistrict::class)->create();
        $culturalHeritage = factory(CulturalHeritage::class)->create(['name' => 'Testing 123']);

        $this->visitRoute('cultural_heritages.show', $culturalHeritage);
        $this->click('edit-cultural_heritage-'.$culturalHeritage->id);
        $this->seeRouteIs('cultural_heritages.edit', $culturalHeritage);

        $this->submitForm(__('cultural_heritage.update'), $this->getEditFields([
            'sub_district_id' => $subDistrict->id,
        ]));

        $this->seeRouteIs('cultural_heritages.show', $culturalHeritage);

        $this->seeText(__('cultural_heritage.updated'));

        $this->seeInDatabase('cultural_heritages', $this->getEditFields([
            'id' => $culturalHeritage->id,
        ]));
    }

    /** @test */
    public function validate_cultural_heritage_name_update_is_required()
    {
        $this->loginAsUser();
        $subDistrict = factory(SubDistrict::class)->create();
        $cultural_heritage = factory(CulturalHeritage::class)->create([
            'name'            => 'Testing 123',
            'sub_district_id' => $subDistrict->id,
        ]);

        // name empty
        $this->patch(route('cultural_heritages.update', $cultural_heritage), $this->getEditFields(['name' => '']));
        $this->assertSessionHasErrors('name');
    }

    /** @test */
    public function validate_cultural_heritage_name_update_is_not_more_than_60_characters()
    {
        $this->loginAsUser();
        $subDistrict = factory(SubDistrict::class)->create();
        $cultural_heritage = factory(CulturalHeritage::class)->create([
            'name'            => 'Testing 123',
            'sub_district_id' => $subDistrict->id,
        ]);

        // name 70 characters
        $this->patch(route('cultural_heritages.update', $cultural_heritage), $this->getEditFields([
            'name' => str_repeat('Test Title', 7),
        ]));
        $this->assertSessionHasErrors('name');
    }

    /** @test */
    public function validate_cultural_heritage_description_update_is_not_more_than_255_characters()
    {
        $this->loginAsUser();
        $subDistrict = factory(SubDistrict::class)->create();
        $cultural_heritage = factory(CulturalHeritage::class)->create([
            'name'            => 'Testing 123',
            'sub_district_id' => $subDistrict->id,
        ]);

        // description 256 characters
        $this->patch(route('cultural_heritages.update', $cultural_heritage), $this->getEditFields([
            'description' => str_repeat('Long description', 16),
        ]));
        $this->assertSessionHasErrors('description');
    }

    /** @test */
    public function user_can_delete_a_cultural_heritage()
    {
        $this->loginAsUser();
        $subDistrict = factory(SubDistrict::class)->create();
        $culturalHeritage = factory(CulturalHeritage::class)->create([
            'sub_district_id' => $subDistrict->id,
        ]);
        factory(CulturalHeritage::class)->create();

        $this->visitRoute('cultural_heritages.edit', $culturalHeritage);
        $this->click('del-cultural_heritage-'.$culturalHeritage->id);
        $this->seeRouteIs('cultural_heritages.edit', [$culturalHeritage, 'action' => 'delete']);

        $this->press(__('app.delete_confirm_button'));

        $this->seeText(__('cultural_heritage.deleted'));

        $this->dontSeeInDatabase('cultural_heritages', [
            'id' => $culturalHeritage->id,
        ]);
    }
}
