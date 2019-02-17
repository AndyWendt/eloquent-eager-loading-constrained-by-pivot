# Eloquent Eager Loading Constrained by Pivot

Example for an article on my site: https://commandz.io/snippets/laravel/eloquent-eager-loading-constrained-by-pivot/

```php
$articlesWithAuthors = Article::where('id', 2)->with('authorsToDisplay')->first()->authorsToDisplay->toArray();

/*
 Returns the following
 [
     [
       "id" => 3,
       "name" => "William Strunk",
       "created_at" => null,
       "updated_at" => null,
       "pivot" => [
         "article_id" => "2",
         "author_id" => "3",
       ],
     ],
     [
       "id" => 5,
       "name" => "E.B. White",
       "created_at" => null,
       "updated_at" => null,
       "pivot" => [
         "article_id" => "2",
         "author_id" => "5",
       ],
     ],
   ]
*/
```

```php
$articlesWithAuthors = Article::where('id', 2)
    ->with([
        'authors' => function ($query) {
            $query->wherePivot('display', true);
        }
    ])->first();

/*
 Returns the following
 [
     [
       "id" => 3,
       "name" => "William Strunk",
       "created_at" => null,
       "updated_at" => null,
       "pivot" => [
         "article_id" => "2",
         "author_id" => "3",
       ],
     ],
     [
       "id" => 5,
       "name" => "E.B. White",
       "created_at" => null,
       "updated_at" => null,
       "pivot" => [
         "article_id" => "2",
         "author_id" => "5",
       ],
     ],
   ]
*/
```
