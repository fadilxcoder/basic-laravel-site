<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;

use App\Category;
use App\Post;
use App\Like;
use App\Dislike;
use App\Comment;
use App\Profile;
use App\User;

use Auth;

class PostController extends Controller
{
    public function index()
    {
        
        /*        
            $data['category] = Category::all();
            return view('posts.post, $data);
        */
        $categories = Category::all();
        return view('posts/post', ['categories'=>$categories]);
    }

    public function addPost(Request $request)
    {
        $this->validate($request,[
            'post_title'    => 'required',
            'post_body'     => 'required',
            'category_id'   => 'required',
            'post_image'    => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:min_width=300,min_height=300'
        ]);
        $posts = new Post();
        $posts->user_id          = Auth::user()->id;
        $posts->category_id      = $request->input('category_id');
        $posts->post_title       = $request->input('post_title');
        $posts->post_body        = $request->input('post_body');

        if(Input::hasFile('post_image'))
        {
            $file = Input::file('post_image'); // same as $request->file('post_image');
            $filename = 'img-'.date('ymd').time().rand(1,10000).'.'.$file->getClientOriginalExtension();
            $file->move(public_path().'/uploads/posts/', $filename);
            //$url = URL::to("/").'/uploads/'.$file->getClientOriginalName();
        }  
        $posts->post_image       = $filename;
        $posts->save();
        return redirect('/home')->with('response','Post created successfully');
    }

    public function viewPost($post_id)
    {
        $post = DB::table("posts")->where('id', '=', $post_id)->get();
        $likeCtrl = Like::where (array('post_id'=>$post_id))->get();
        $dislikeCtrl = Dislike::where (array('post_id'=>$post_id))->get();
        $comments = DB::table('users')
                    ->join('comments', 'users.id', '=', 'comments.user_id')
                    ->join('posts', 'comments.post_id', '=', 'posts.id')
                    ->select('users.*', 'comments.*')
                    ->where(['comments.post_id'=>$post_id])
                    ->get();
        $categories = Category::all();
        return view('posts.view',['specific_post'=>$post, 'categories'=>$categories, 'likes'=>$likeCtrl, 'dislikes'=>$dislikeCtrl, 'comments'=>$comments ]);
    }

    public function editPost($post_id)
    {
        //return $post_id;
        //$data['specific_post'] = DB::table('posts')->where('id', '=', $post_id)->get();
        $data['specific_post'] = $post = Post::find($post_id);
        $data['categories'] = Category::all();
        $data['selected_category'] = Category::find($post->category_id);
        return view('posts.edit',$data);
    }

    public function editPostP(Request $request, $post_id)
    {
        $this->validate($request,[
            'post_title'    => 'required',
            'post_body'     => 'required',
            'category_id'   => 'required',
            'post_image'    => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:min_width=300,min_height=300'
        ]);
        
        $posts = new Post();
        $posts->user_id          = Auth::user()->id;
        $posts->category_id      = $request->input('category_id');
        $posts->post_title       = $request->input('post_title');
        $posts->post_body        = $request->input('post_body');

        if(Input::hasFile('post_image'))
        {
            $file = Input::file('post_image');
            $filename = 'img-'.date('ymd').time().rand(1,10000).'.'.$file->getClientOriginalExtension();
            $file->move(public_path().'/uploads/posts/', $filename);
            $posts->post_image       = $filename;
            $data = array(
                'post_title'    => $posts->post_title,
                'post_body'     => $posts->post_body,
                'category_id'   => $posts->category_id,
                'user_id'       => $posts->user_id,
                'post_image'    => $posts->post_image
            );

        } 
        else
        {
            $data = array(
                'post_title'    => $posts->post_title,
                'post_body'     => $posts->post_body,
                'category_id'   => $posts->category_id,
                'user_id'       => $posts->user_id
            );
        } 
        
        Post::where('id',$post_id)->update($data);
        $posts->update(); 
        return redirect('/home')->with('response','Post updated successfully');
    }

    public function deletePost($post_id)
    {
        //return $post_id;
        Post::where('id', $post_id)->delete();
        return redirect('/home')->with('response', 'Post deleted successfully');
    }

    public function like($id)
    {
        $loggin_user = Auth::user()->id;
        $like_user = Like::where(array('user_id'=>$loggin_user, 'post_id'=>$id))->first();
        if(empty($like_user)):
            $user_id = Auth::user()->id;
            $email = Auth::user()->email;
            $post_id = $id;

            $like = new Like;
            $like->user_id = $user_id;
            $like->post_id = $post_id;
            $like->email = $email;
            $like->save();

            Dislike::where(['post_id'=>$post_id, 'user_id'=>$user_id])->delete();

            return redirect('view-article/'.$id);
        else:
            return redirect('view-article/'.$id);
        endif;
    }

    public function dislike($id)
    {
        $loggin_user = Auth::user()->id;
        $dislike_user = Dislike::where(array('user_id'=>$loggin_user, 'post_id'=>$id))->first();
        if(empty($like_user)):
            $user_id = Auth::user()->id;
            $email = Auth::user()->email;
            $post_id = $id;

            $dislike = new Dislike;
            $dislike->user_id = $user_id;
            $dislike->post_id = $post_id;
            $dislike->email = $email;
            $dislike->save();

            Like::where(['post_id'=>$post_id, 'user_id'=>$user_id])->delete();

            return redirect('view-article/'.$id);
        else:
            return redirect('view-article/'.$id);
        endif;
    }

    public function comment(Request $request, $post_id)
    {
        $this->validate($request,[
            'comment'    => 'required'
        ]);
        $comment = new Comment();
        $comment->user_id = Auth::user()->id;
        $comment->post_id = $post_id;
        $comment->comment = $request->input('comment');

        $comment->save();

        return redirect('/view-article/'.$post_id)->with('response','Comment posted successfully');
    }

    public function search(Request $request)
    {
        $this->validate($request,[
            'search'    => 'required'
        ]);

        $user_id = Auth::user()->id;
        $profile = DB::table('users')
                    ->join('profiles','users.id', '=', 'profiles.user_id')
                    ->select('users.*','profiles.*')
                    ->where(['profiles.user_id' => $user_id])
                    //->get();
                    ->first();

        $keyword = $request->input('search');
        $posts = Post::where('post_title', 'LIKE', '%'.$keyword.'%')->latest()->paginate(2);

        //var_dump($profile);
        //exit;

        return view('home', ['profile_data' => $profile, 'posts' => $posts]);
    }
}
