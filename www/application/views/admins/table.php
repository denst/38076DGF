<div id="tab-1">
    <div class="sepH_c">
            <table cellpadding="0" cellspacing="0" border="0" id="admin_data_table" class="display">
                <thead>
                    <tr>
                        <th><div class="th_wrapp">N</div></th>
                        <th><div class="th_wrapp">Admin ID (login)</div></th>
                        <th><div class="th_wrapp">Name</div></th>
                        <th><div class="th_wrapp">Logins Count</div></th>
                        <th><div class="th_wrapp">Last Login</div></th>
                        <th><div class="th_wrapp">Role</div></th>
                        <th><div class="th_wrapp">Status</div></th>
                        <th style="width: 95px;"><div class="th_wrapp">Actions</div></th>
                    </tr>
                </thead>
                <tbody>
                <?php $index = 1 ?>
                <?php foreach ($admins as $admin): ?>
                    <tr>
                        <td><?php echo $index ?></td>
                        <td><a href="<?=URL::base()?><?=$role?>/admins/view/<?=$admin->id?>"><?php echo $admin->username ?></a></td>
                        <td><?php echo $admin->name ?> <?php echo $admin->grfathername ?> <?php echo $admin->fathername ?></td>
                        <td><?php echo $admin->logins ?></td>
                        <td><?php echo $admin->last_login ?></td>
                        <td><?php echo Helper_User::getUserRole($admin) ?></td>
                        <td><?php echo $admin->status == 1 ? 'Approved Admin' : 'Pending Review'?></td>
                        <td>
                            <div id="actions">
                                <?php if($role == 'sadmin' AND $admin->status == 0): ?>
                                <a href="<?php echo URL::base() ?><?=$role?>/admins/approve/<?php echo $admin->id ?>" class="sepV_a" title="Approve">
                                    <button class="action-button">
                                        <img src="<?=URL::base()?>laguadmin/images/icons/preview_gray.png" alt="" />
                                    </button>
                                </a>
                                <?php endif; ?>
                                <a href="<?php echo URL::base() ?><?=$role?>/admins/edit/<?php echo $admin->id ?>" class="sepV_a" title="Edit">
                                    <button class="action-button">
                                        <img src="<?=URL::base()?>laguadmin/images/icons/pencil_gray.png" alt="" />
                                    </button>
                                </a>
                                <button name="delete" value="<?=$admin->id?>" data-toggle="modal" href="#deleteAdminModal" 
                                    class="action-button admin_delete_button">
                                    <a href="" title="Delete">
                                        <img src="<?=URL::base()?>laguadmin/images/icons/trashcan_gray.png" alt="" />
                                    </a>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <? $index++?>
                <?php endforeach; ?>
                </tbody>
            </table>
    </div>
</div>
<div style="display: none;" class="modal hide" id="deleteAdminModal">
    <div class="tac">
        <form action="<?=URL::base()?><?=$role?>/admins/delete" method="post">
            <input id="delete_admin_id" type="hidden" name="admin_id" value="" />
            <p class="sepH_b">Are you sure you want to delete admin?</p>
            <button type="submit" id="clear_yes" class="btn btn_d sepV_a">Yes</button>
            <button id="clear_no" class="btn btn_a" data-dismiss="modal">No</button >
        </form>
    </div>
</div>