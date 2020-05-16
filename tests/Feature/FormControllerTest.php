<?php

namespace Tests\Feature;

use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FormControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index_page_has_all_elements()
    {
        $response = $this->get('/');
        $response->assertViewHas('companySymbols');
        $response->assertSeeTextInOrder(['Check the historical quotes of a Company over a specified period of time','Company Symbol','Email','Start Date','End Date']);
        $response->assertStatus(200);
    }

    public function test_search_fields_valid()
    {
        $today = today()->format('Y-m-d');
        $faker = Faker::create();
        $params = ['company_symbol'=>'AAL','email'=>$faker->email,'start_date'=>$today,'end_date'=>$today];
        $response = $this->post(route('store'),$params);
        $response->assertStatus(200);
        $response->assertSessionDoesntHaveErrors(['company_symbol','email','start_date','end_date']);
    }

    public function test_search_fields_invalid_date_format()
    {
        $faker = Faker::create();
        $params = ['company_symbol'=>'GOOD','email'=>$faker->email,'start_date'=>today(),'end_date'=>today()];
        $response = $this->post(route('store'),$params);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['start_date','end_date']);
        $response->assertSessionDoesntHaveErrors(['company_symbol','email']);
    }

    public function test_search_fields_invalid_all_inputs_text()
    {
        $faker = Faker::create();

        $params = ['company_symbol'=>$faker->word,'email'=>$faker->word,'start_date'=>$faker->word,'end_date'=>$faker->word];
        $response = $this->post(route('store'),$params);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['company_symbol','email','start_date','end_date']);
    }
}
