<?php

namespace Tests\Feature;

use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FormControllerTest extends TestCase
{
    use withFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index_page_has_all_elements()
    {
        $response = $this->get('/');
        $response->assertViewHas('companySymbols');
        $response->assertSeeTextInOrder(['Select a company Symbol and view its historical quotes over a specified period of time','Company Symbol','Email','Start Date','End Date']);
        $response->assertStatus(200);
    }

    public function test_search_fields_valid()
    {

        $params = ['company_symbol'=>'AAL','email'=>$this->faker->email,'start_date'=>$this->today(),'end_date'=>$this->today()];
        $response = $this->post(route('store'),$params);
        $response->assertStatus(200);
        $response->assertSessionDoesntHaveErrors(['company_symbol','email','start_date','end_date']);

        $params = ['company_symbol'=>'GOOD','email'=>$this->faker->email,'start_date'=>$this->yesterday(),'end_date'=>$this->today()];
        $response = $this->post(route('store'),$params);
        $response->assertStatus(200);
        $response->assertSessionDoesntHaveErrors(['company_symbol','email','start_date','end_date']);
    }

    public function test_search_fields_invalid_end_date_greater_than_start_date()
    {

        $params = ['company_symbol'=>'GOOD','email'=>$this->faker->email,'start_date'=>$this->today(),'end_date'=>$this->yesterday()];
        $response = $this->post(route('store'),$params);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['start_date','end_date']);
        $response->assertSessionDoesntHaveErrors(['company_symbol','email']);

        $messages = session('errors')->getMessages();
        $this->assertEquals($messages['start_date'][0],'The start date must be a date before or equal to end date.' );
        $this->assertEquals($messages['end_date'][0],'The end date must be a date after or equal to start date.' );

    }

    public function test_search_fields_invalid_dates_greater_than_today()
    {

        $params = ['company_symbol'=>'GOOD','email'=>$this->faker->email,'start_date'=>$this->tomorrow(),'end_date'=>$this->tomorrow()];
        $response = $this->post(route('store'),$params);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['start_date','end_date']);
        $response->assertSessionDoesntHaveErrors(['company_symbol','email']);

        $messages = session('errors')->getMessages();
        $this->assertEquals($messages['start_date'][0],'The start date must be a date before or equal to today.' );
        $this->assertEquals($messages['end_date'][0],'The end date must be a date before or equal to today.' );
    }

    public function test_search_fields_invalid_date_format()
    {

        $params = ['company_symbol'=>'GOOD','email'=>$this->faker->email,'start_date'=>today(),'end_date'=>today()];
        $response = $this->post(route('store'),$params);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['start_date','end_date']);
        $response->assertSessionDoesntHaveErrors(['company_symbol','email']);

        $messages = session('errors')->getMessages();
        $this->assertEquals($messages['start_date'][0],'The start date does not match the format Y-m-d.' );
        $this->assertEquals($messages['end_date'][0],'The end date does not match the format Y-m-d.' );
    }

    public function test_search_fields_invalid_email_invalid_symbol_invalid_dates()
    {
        $params = ['company_symbol'=>$this->faker->word,'email'=>$this->faker->word,'start_date'=>$this->faker->word,'end_date'=>$this->faker->word];
        $response = $this->post(route('store'),$params);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['company_symbol','email','start_date','end_date']);

        $messages = session('errors')->getMessages();
        $this->assertEquals($messages['company_symbol'][0],'The selected company symbol is invalid.' );
        $this->assertEquals($messages['email'][0],'The email must be a valid email address.' );
        $this->assertEquals($messages['start_date'][0],'The start date is not a valid date.' );
        $this->assertEquals($messages['end_date'][0],'The end date is not a valid date.' );
    }

    public function test_search_fields_invalid_no_inputs_given()
    {
        $params = ['company_symbol'=>null,'email'=>null,'start_date'=>null,'end_date'=>null];
        $response = $this->post(route('store'),$params);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['company_symbol','email','start_date','end_date']);

        $messages = session('errors')->getMessages();
        $this->assertEquals($messages['company_symbol'][0],'The company symbol field is required.' );
        $this->assertEquals($messages['email'][0],'The email field is required.' );
        $this->assertEquals($messages['start_date'][0],'The start date field is required.' );
        $this->assertEquals($messages['end_date'][0],'The end date field is required.' );
    }
}
