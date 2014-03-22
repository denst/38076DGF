<?php if(count($admins) > 0): ?>
<table class="table table-condensed">
        <thead>
            <tr>
                <th>Admin ID (login)</th>
                <th>Name</th>
                <th>Logins Count</th>
                <th>Last Login</th>
                <th>Role</th>
                <th style="width: 10%">Status</th>
                <th style="width: 20%">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($admins as $admin): ?>
            <tr>
                <th><?php echo $admin->username ?></th>
                <th><?php echo $admin->name ?> <?php echo $admin->fathername ?> <?php echo $admin->grfathername ?></th>
                <th><?php echo $admin->logins ?></th>
                <th><?php echo $admin->last_login ?></th>
                <th><?php echo Helper_User::getUserRole($admin) ?></th>
                <th><?php echo $admin->status == 1 ? 'Approved Admin' : 'Pending Review'?></th>
                <th>
                    <?php if($admin->status == 0): ?>
                        <a href="<?php echo URL::base() ?>main/approve/admin/<?php echo $admin->id ?>">Approve</a>
                    <?php endif; ?>
                    <a href="<?php echo URL::base() ?>admins/edit/<?php echo $admin->id ?>">View/Edit</a>
                </th>
            </tr>
        <?php endforeach; ?>
        </tbody>
</table>
<?php else: ?>
    <p>The admins are not found</p>
<?php endif; ?>
<a href="<?php echo URL::base() ?>admins/new">Create admin</a>