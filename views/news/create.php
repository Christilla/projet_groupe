<h1>créer une new</h1>

<form method="post" action="<?= $helper->base_url('create/'.$data['id'].'') ?>">
    <input name="title" type="text" value="<?= $data['title'] ?>">
    <textarea name="content" row="10"><?= $data['content'] ?></textarea>
    <input type="submit" value="envoyer">
</form>
