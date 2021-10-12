<table class="table table-bordered">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col"><a href="<?= $sort['login'] ?>" class="text-dark">login <i class="fa fa-fw fa-sort"></i></a></th>
            <th scope="col"> <a href="<?= $sort['email'] ?>" class="text-dark">email <i class="fa fa-fw fa-sort"></i></a></th>
            <th scope="col">description</th>
            <th scope="col"><a href="<?= $sort['status'] ?>" class="text-dark">status <i class="fa fa-fw fa-sort"></i></a></th>
            <th scope="col">changed</th>
            <?php
            if ($isLogin) {
            ?><th scope="col">options</th> <?
                                        }
                                            ?>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($table as $key => $task) {
        ?>
            <tr>
                <th scope="row"><?= $task['id'] ?></th>
                <td><?= $task['login'] ?></td>
                <td><?= $task['email'] ?></td>
                <td><?= $task['description'] ?></td>
                <td><?= ($task['status'] ? 'done' : 'not done') ?></td>
                <td><?= ($task['changed'] ? 'changed' : '') ?></td>
                <?php
                if ($isLogin) {
                ?>
                    <td>
                        <a class="btn btn-primary" href="<?= $task['doneUrl'] ?>" role="button">✓</a>
                        <a class="btn btn-primary" href="<?= $task['editUrl'] ?>" role="button">🖊</a>
                    </td>
                <?
                }
                ?>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>
<div class="px-2">
    <a class="btn btn-primary" href="/add-task/" role="button">Add Task</a>
</div>
<div class="px-2 py-2">
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <?php
            foreach ($pagination as $key => $page) {
            ?><li class="page-item <?= ($page['active'] ? 'active' : '') ?>"><a class="page-link" href="<?= $page['url'] ?>"><?= $page['label'] ?></a></li><?
                                                                                                                                                        }
                                                                                                                                                            ?>
        </ul>
    </nav>
</div>