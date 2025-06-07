$(function(){
    fetch('https://misoon.net/pachiyame/backend/api/get_user.php', {
        credentials: 'include',
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        },
    })
        .then(res => res.json())
        .then(function(data){
            console.log(data);
            if(data.msg === false){
                window.location.replace('/pachiyame/frontend/login.html');
            }
        })
        .catch(err => {
            console.log(err);
        }
    );

    //articlesAPIにPOST
    $('#post-btn').click(async function(){
        const body = $('#post-body').val();
        const tag = $('#post-tag').val().split(',');
        //API呼び出し
        fetch('https://misoon.net/pachiyame/backend/api/articles.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                body: body,
                tags: tag
            })
        })
            .then(res => res.json())
            .then(async function(data){
                console.log(data);
                //強制的に500ms遅らせる。←別の方法で実装する必要あり。
                await articles_get();
            });
        });
})

//articlesAPIにGET
function articles_get(){
    //API呼び出し
    fetch('https://misoon.net/pachiyame/backend/api/articles.php', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(res => res.json())
        .then(function(data){
            $('.posts-item').html('');
            data.forEach(data2 => {
                $('.posts-item').append(
                    `
                    <div class="item card w-50">
                        <div class="card-body">
                            <p class="card-tex">${data2.body}</p>
                            <p>${data2.tags}</p>
                            <a href="#" class="btn btn-primary">編集</a>
                            <a href="#" class="btn btn-primary">削除</a>
                        </div>
                    </div>
                    `);
            });
        })
}
articles_get();

