        <script>
        function dislike(id, el) {
            el.attr('data-likes', parseInt(el.attr('data-likes')) - 1);
            var ch = el.children('img').attr('src', 'https://img.icons8.com/material-outlined/24/000000/hearts.png');
           
            ch.hide();
            ch.show(500);
            $.ajax({
                url: '/insider/events/'+id+'/dislike',
            });
            el.children('.likes1').html(el.attr('data-likes'));

        }
        function like(id, el) {
            el.attr('data-likes', parseInt(el.attr('data-likes')) + 1);
            
            var ch = el.children('img').attr('src', 'https://img.icons8.com/material/24/000000/like.png');
            ch.hide();
            ch.show(500);
            $.ajax({
                url: '/insider/events/'+id+'/like',
            });

            el.children('.likes1').html(el.attr('data-likes'));

        }
        function toggleLike(id, el)
        {
            if (el.attr('data-liked') == 'true')
            {
                dislike(id, el);
                el.attr('data-liked', 'false');
            }
            else
            {
                like(id, el);
                el.attr('data-liked', 'true');
            }

        }
    </script>