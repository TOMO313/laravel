# Laravelによる動画アップロード機能
## 1 create.blade.phpに動画をアップロードするための箱を準備
**create.blade.php**
```
<form method="POST" action="{{ route('store') }}" enctype="multipart/form-data">
    @csrf
    <div>
        <label for="video">Video</label>
        {{-- accept="video/*"にすることで、ファイル選択ダイアログで動画ファイルのみが選択できるようになる --}}
        <input type="file" name="video" accept="video/*" />
        @error('video')
        <div>{{ $message }}</div>
        @enderror
    </div>
    <div>
        <button type="submit">Create</button>
    </div>
</form>
```
## 2 web.phpに動画を保存するためのルーティングを定義
**web.php**
```
Route::controller(PostController::class)->middleware('auth')->group(function () {
    Route::post('/posts', 'store')->name('store');
});
```
## 3 PostControllerに動画を保存するためのメソッドを定義
**PostController.php**
```
public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            //maxはキロバイト単位
            'video' => 'nullable|file|mimes:mp4,mov,avi,wmv|max:40000',
        ]);
    
        $post = new Post();
        $post->title = $request->title;
        $post->body = $request->body;
        if ($request->hasFile('video')) {
            //store('videos', 'public')で、storage/app/public/videosに保存する。
            $videoPath = $request->file('video')->store('videos', 'public');
            $post->video_path = $videoPath;
        }
        $post->user_id = Auth::id();
        $post->save();
    
        //with()はセッションにデータを保存する。
        return redirect()->route('index')->with('success', 'Post created successfully!');
    }
```
## 4 web.phpに動画を表示するためのルーティングを定義
**web.php**
```
Route::controller(PostController::class)->middleware('auth')->group(function () {
    Route::get('/', 'index')->name('index');
});
```
## 5 PostController.phpに動画を表示するためのメソッドを定義
**PostControlller**
```
public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(3);
        return view('posts.index', compact('posts'));
    }
```
## 6 index.blade.phpに動画を表示するための記述
```
<div class="p-6">
    @foreach($posts as $post)
    <div class="w-3/5 mx-auto text-center rounded shadow-lg bg-white p-6">
        <ul>
            <li>
                @if($post->video_path)
                {{-- controlsはビデオプレーヤーの操作コントロールを表示するためのもの --}}
                <video width="320" height="240" controls>
                    {{-- シンボリックリンクを作成することで、public/storageからstorage/app/publicにアクセスできるようにする --}}
                    {{-- type="video/mp4"はMIMEタイプ(画像、音声、動画などのマルチメディアを識別するための情報)を表すもので、videoがファイルの大きな分類(タイプ)で、mp4がファイルのより詳細な種類(サブタイプ)を示している --}}
                    {{-- movファイルを表示させようとtype="video/quicktime"とすると、ブラウザによって動画が表示されない場合がある。その場合はtype="video/mp4"としてみると表示される。 --}}
                    <source src="{{ asset('storage/' . $post->video_path) }}" type="video/mp4">
                    {{-- <video>内のテキストはブラウザが<video>をサポートしていない時に表示される --}}
                    Your browser does not support the video tag
                </video>
                @endif
            </li>
        </ul>
    </div>
    @endforeach
</div>
```
