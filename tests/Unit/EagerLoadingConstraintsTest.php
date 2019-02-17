<?php

namespace Tests\Unit;

use App\Article;
use Tests\CreatesApplication;
use Tests\TestCase;


class EagerLoadingConstraintsTest extends TestCase
{
    use CreatesApplication;

    /**
     * @test
     */
    public function it_returns_all_authors_without_an_eager_loading_constraint_on_the_pivot()
    {
        // Arrange
        $expectedAuthors = [3 => 'William Strunk', 5 => 'E.B. White', 6 => 'William Strunk J.R.'];

        // Act
        $articlesWithAuthors = Article::where('id', 2)->with('authors')->first();

        // Assert
        $this->assertCount(count($expectedAuthors), $articlesWithAuthors->authors);
        $articlesWithAuthors->authors->each(function ($author) use ($expectedAuthors) {
            $this->assertContains($author->name, $expectedAuthors);
            $this->assertArrayHasKey($author->id, $expectedAuthors);
        });
    }

    /**
     * @test
     */
    public function it_returns_only_authors_with_display_set_to_true_on_the_pivot_when_using_eager_loading_constraints()
    {
        // Arrange
        $expectedAuthors = [3 => 'William Strunk', 5 => 'E.B. White'];
        $authorsToNotBeReturned = [6 => 'William Strunk J.R.'];

        // Act
        $articlesWithAuthors = Article::where('id', 2)
            ->with([
                'authors' => function ($query) {
                    $query->wherePivot('display', true);
                }
            ])->first();

        // Assert
        $this->assertCount(count($expectedAuthors), $articlesWithAuthors->authors);
        $articlesWithAuthors->authors->each(function ($author) use ($expectedAuthors, $authorsToNotBeReturned) {
            $this->assertContains($author->name, $expectedAuthors);
            $this->assertArrayHasKey($author->id, $expectedAuthors);
            $this->assertNotContains($author->name, $authorsToNotBeReturned);
            $this->assertArrayNotHasKey($author->id, $authorsToNotBeReturned);
        });
    }
}
