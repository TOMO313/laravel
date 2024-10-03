const likeBtn = document.querySelector(".like-btn");
likeBtn.addEventListener("click", async (e) => {
    const clickedEl = e.target; //e.targetでクリックした要素(iタグ)を取得
    clickedEl.classList.toggle("liked"); //toggleプロパティでlikedが存在すれば削除、存在しなければ追加
    const postId = e.target.id;
    try{
        const response = await fetch("/posts/like", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
            },
            body: JSON.stringify({post_id: postId}),
        });

        if (!response.ok) {
            throw new Error(
                `レスポンスステータス: ${response.status}`
            );
        }

        const data = await response.json();
        clickedEl.nextElementSibling.innerHTML = data.likesCount;
    } catch (error) {
        console.log(error);
    }
});