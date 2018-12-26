<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Requests\StoreArticleRequest;
use App\Repositories\ArticlesRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ArticlesController extends Controller
{

    protected $articlesRepository;

    public function __construct( ArticlesRepository $articlesRepository )
    {
        $this->middleware( 'auth' )->except( ['index', 'show'] );
        $this->articlesRepository = $articlesRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = $this->articlesRepository->getArticlesFeed();
        return view( 'articles.index', ['articles' => $articles] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view( 'articles.create' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreArticleRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store( StoreArticleRequest $request )
    {
        $topics  = $this->articlesRepository->normalizeTopic( $request->get( 'topics' ) );
        $data    = [
            'title'   => $request->get( 'title' ),
            'body'    => $request->get( 'body' ),
            'user_id' => Auth::id(),
        ];
        $article = $this->articlesRepository->create( $data );
        $article->topics()->attach( $topics );
        return redirect()->route( 'articles.show', [$article->id] );
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show( $id )
    {
        $article = $this->articlesRepository->byId( $id );
        return view( 'articles.show', compact( 'article', $article ) );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit( $id )
    {
        //
        $article = $this->articlesRepository->byIdWithTopics( $id );
        return view( 'articles.edit', compact( 'article', $article ) );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StoreArticleRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update( StoreArticleRequest $request, $id )
    {
        $article = $this->articlesRepository->byId( $id );
        $topics  = $this->articlesRepository->normalizeTopic( $request->get( 'topics' ) );

        $article->update( [
            'title' => $request->title,
            'body'  => $request->body,
        ] );

        $article->topics()->sync( $topics );
        return redirect()->route( 'articles.show', [$article->id] );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id )
    {
        $this->articlesRepository->delete( $id );
        return redirect()->route( 'articles.index',['articles' => $articles]);
    }
}
