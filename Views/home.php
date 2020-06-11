<div class="feed">
    <form method="post">
        <textarea name="tweet"  class="tweet-box"></textarea>
        <button type="submit">Tweetar</button>
    </form>
</div>


<div class="right-side">
    <h4>Relacionamentos</h4>
    <div class="middle"><?php echo $viewData['followers']?><br>Seguidores</div>
    <div class="middle"><?php echo $viewData['following']?><br>Seguindo</div>
    <div style="clear:both"></div>

    <h4>Sugestões de amigos</h4>
    <table border='0' width='100%'>
        <tr>
            <td width="80%"></td>
            <td></td>
        </tr>
        <?php foreach($viewData['suggestions'] as $suggestion): ?>
        <tr>
            <td><?php echo $suggestion['name']?></td>
            <td>
            <?php if($suggestion['followed'] == 0): ?>
                <a href="./home/follow/<?php echo $suggestion['id'] ?>">Seguir</a>
            <?php else: ?>
                <a href="./home/unfollow/<?php echo $suggestion['id'] ?>">Deixar de Seguir</a>    
            <?php endif;?>
            </td>
        </tr>
        <?php endforeach;?>
    </table>
</div>
<?php foreach($viewData['tweets'] as $tweet): ?>
    <strong><?php echo $tweet['name']?></strong> - <?php echo date('H:i',strtotime($tweet['post_time']))?> <br>
    <p><?php echo $tweet['tweet']?></p>
    <hr>

    <?php endforeach;?>


