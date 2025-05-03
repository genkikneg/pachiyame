//articlesAPIにPOST
$('#post-btn').click(function(){
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
        .then(function(data){
            console.log(data);
            //強制的に500ms遅らせる。←別の方法で実装する必要あり。
            setTimeout(() =>{
                articles_get();
            }, 500);
        });
});

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
            $('.sea-area').html('');
            data.forEach(data2 => {
                $('.sea-area').append(
                    `
                    <div class="item">
                        <p>${data2.body}</p>
                        <b>${data2.tags}</b>
                    </div>
                    `);
            });
        })
}
articles_get();