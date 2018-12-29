<?php
/**
 * Created by PhpStorm.
 * User: linxb
 * Date: 2018/12/25
 * Time: 下午9:34
 */

namespace App\Repositories;

use App\Article;
use App\Topic;

class ArticlesRepository
{
    public function byId( $id )
    {
        return Article::where( 'id', $id )->first();
    }

    public function normalizeTopic( array $topics )
    {
        return collect( $topics )->map( function ( $topic ) {
            if ( is_numeric( $topic ) ) {
                return (int)$topic;
            }
            $newTopic = Topic::create( ['name' => $topic] );
            return $newTopic->id;
        } )->toArray();
    }

    public function create( array $attributes )
    {
        return Article::create( $attributes );
    }

    public function byIdWithTopicsAndUser( $id )
    {
        return Article::where( 'id', $id )->with( 'topics' )->with( 'user' )->first();
    }

    public function delete( $id )
    {
        return Article::destroy( $id );
    }

    public function getArticlesFeed()
    {
        return Article::published()->latest('create_at')->paginate();
    }

    public function ByTopicId($topicId)
    {
        return Article::whereHas('topics',function ($query) use ($topicId){
            $query->where('topic_id', $topicId);
        })->published()->latest('updated_at')->paginate();
    }


    public function getArticlesHidden()
    {
        return Article::hidden()->latest( 'create_at' )->paginate();
    }
}
