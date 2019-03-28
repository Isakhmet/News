<?php

namespace App\Http\GraphQL\Mutations;

use App\Models\Locale;
use App\Models\News;
use App\Models\NewsTags;
use App\Models\Tags;
use Elasticsearch\ClientBuilder;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class LatestNews
{
    /**
     * Return a value for the field.
     *
     * @param null $rootValue Usually contains the result returned from the parent field. In this case, it is always `null`.
     * @param array $args The arguments that were passed into the field.
     * @param GraphQLContext|null $context Arbitrary data that is shared between all fields of a single query.
     * @param ResolveInfo $resolveInfo Information about the query itself, such as the execution state, the field name, path to the field from the root, and more.
     *
     * @return mixed
     */
    public function resolve($rootValue, array $args, GraphQLContext $context = null, ResolveInfo $resolveInfo)
    {
        $body = [];

        if (isset($args)){

            $tags_ids = $args['tags'];
            $locale = $args['locale'];
            unset($args['tags']);
            unset($args['locale']);

            $locale_exist = Locale::where('locale', $locale)->get(['id'])->toArray();

            if(!empty($locale_exist)){
                $args['locale_id'] = $locale_exist[0]['id'];
            }

            $tags_name = Tags::whereIn('id',$tags_ids)->get(['name'])->toArray();

            $news = News::create($args);
            $news = $news->where('alias', $args['alias'])->with('localeNews')->get()->toArray();

            $body['locale'] = $news[0]['locale_news']['locale'];
            unset($news[0]['locale_news']);
            unset($news[0]['locale_id']);

            $news_id = $news[0]['id'];
            foreach ($tags_ids as $id){
                NewsTags::create([
                    'news_id' => $news_id,
                    'tags_id' => $id
                ]);
            }

            $tags = [];
            foreach ($tags_name as $item){
                $tags[] = $item['name'];
            }

            foreach ($news[0] as $key => $item){
                $body[$key] = $item;
            }

            $body['tags'] = $tags;

            $params = [
                'index' => env('ES_INDEX', 'news_api'),
                'type' => env('ES_TYPE', 'news'),
                'id' => $news_id,
                'body' => $body
            ];

            $es = ClientBuilder::create()->build();
            $client = $es->index($params);

            return isset($client['result']) ? $client['result'] : 'Something is wrong';
        }
    }
}
