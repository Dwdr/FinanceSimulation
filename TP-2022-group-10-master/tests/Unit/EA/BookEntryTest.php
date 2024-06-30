<?php

namespace Tests\Unit\EA;

use App\Models\EA\BookEntry;
use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use SebastianBergmann\Comparator\Book;


class BookEntryTest extends TestCase
{
  use WithFaker;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testStore()
    {
      //$book_entry = factory(BookEntry::class)->create();
      //$this->assertSame('https://www.gravatar.com/avatar/' . md5(strtolower(trim($this->email))), $user->getGravatar());
    }

  /** @test */
  public function it_can_create_a_bookentry()
  {
    $data = [
      'entry_date' => $this->faker->date(),
      'subaccount' => $this->faker->numberBetween(1,5),
      'opening_amount' => $this->faker->numberBetween(1000,5000),
      'closing_amount' => $this->faker->numberBetween(7000,9000),
      'cash_withdraw' => $this->faker->numberBetween(0,2000),
    ];

    $ber = new BookEntryRepository(new BookEntry);
    $carousel = $carouselRepo->createCarousel($data);

    $this->assertInstanceOf(Carousel::class, $carousel);
    $this->assertEquals($data['title'], $carousel->title);
    $this->assertEquals($data['link'], $carousel->link);
    $this->assertEquals($data['image_src'], $carousel->src);
  }
}
