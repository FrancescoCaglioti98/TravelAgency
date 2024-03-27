<?php

namespace Tests\Feature\Tour;

use App\Models\Tour;
use App\Models\Travel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListTest extends TestCase
{

    use RefreshDatabase;

    public function test_tours_list_by_travel_slug_returns_correct_tours()
    {
        $travel = Travel::factory()->create();
        $tour = Tour::factory()->create( ['travel_id' => $travel->id] );

        $response = $this->get(  '/api/v1/travels/' . $travel->slug . '/tours');
        $response->assertStatus( 200 );
        $response->assertJsonCount( 1, 'data' );
        $response->assertJsonFragment( ['id' => $tour->id] );

    }

    public function test_tour_price_is_shown_correctly()
    {

        $travel = Travel::factory()->create();
        Tour::factory()->create([
            'travel_id' => $travel->id,
            'price' => 123.45
        ]);


        $response = $this->get(  '/api/v1/travels/' . $travel->slug . '/tours');
        $response->assertStatus( 200 );
        $response->assertJsonCount( 1, 'data' );
        $response->assertJsonFragment( ['price' => '123.45'] );

    }

    public function test_tour_list_returns_pagination()
    {

        $travel = Travel::factory()->create();
        Tour::factory(16)->create(['travel_id' => $travel->id]);

        $response = $this->get(  '/api/v1/travels/' . $travel->slug . '/tours');
        $response->assertStatus( 200 );
        $response->assertJsonCount( self::LARAVEL_DEFAULT_PAGINATION_SIZE, 'data' );
        $response->assertJsonPath( 'meta.current_page', 1 );


    }


    public function test_tour_list_sort_by_starting_date_correctly(): void
    {
        $travel = Travel::factory()->create();
        $laterTour = Tour::factory()->create([
            'travel_id' => $travel->id,
            'starting_date' => now()->addDays(5),
            'ending_date' => now()->addDays(8)
        ]);
        $earlierTour = Tour::factory()->create([
            'travel_id' => $travel->id,
            'starting_date' => now(),
            'ending_date' => now()->addDays(3)
        ]);

        $response = $this->get(  '/api/v1/travels/' . $travel->slug . '/tours');
        $response->assertStatus( 200 );

        $response->assertJsonPath( 'data.0.id', $earlierTour->id );
        $response->assertJsonPath( 'data.1.id', $laterTour->id );
    }

    public function test_tour_list_filter_by_price_correctly(): void
    {
        $travel = Travel::factory()->create();
        $expensiveTour = Tour::factory()->create([
            'travel_id' => $travel->id,
            'price' => 200
        ]);
        $cheapTour = Tour::factory()->create([
            'travel_id' => $travel->id,
            'price' => 101
        ]);


        $endpoint = '/api/v1/travels/' . $travel->slug . '/tours';

        $response = $this->get( $endpoint . '?priceFrom=100' );
        $response->assertStatus( 200 );
        $response->assertJsonCount( 2, 'data' );
        $response->assertJsonFragment( ['id' => $cheapTour->id] );
        $response->assertJsonFragment( ['id' => $expensiveTour->id] );


        $response = $this->get( $endpoint . '?priceFrom=150' );
        $response->assertStatus( 200 );
        $response->assertJsonCount( 1, 'data' );
        $response->assertJsonMissing( ['id' => $cheapTour->id] );
        $response->assertJsonFragment( ['id' => $expensiveTour->id] );


        $response = $this->get( $endpoint . '?priceFrom=300' );
        $response->assertStatus( 200 );
        $response->assertJsonCount( 0, 'data' );
        $response->assertJsonMissing( ['id' => $cheapTour->id] );
        $response->assertJsonMissing( ['id' => $expensiveTour->id] );

    }

}
