<div id="achievement-block">
        <table  cellpadding="0" cellspacing="0" border="0" class="table-records table_a smpl_tbl">
            <thead>
                <tr>
                    <th><div class="th_wrapp">Date</div></th>
                    <th><div class="th_wrapp">Achievement</div></th>
                    <th><div class="th_wrapp">Notes</div></th>
                    <? if($role == 'sadmin' OR $role == 'admin'):?>
                        <th><div class="th_wrapp">Action</div></th>
                    <? endif?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($records as $record): ?>
                <tr>
                    <td><?php echo date('d-m-y', $record->date) ?></td>
                    <td><?php echo $record->achievement ?></td>
                    <td><?php echo $record->notes ?></td>
                    <? if($role == 'sadmin' OR $role == 'admin'):?>
                        <td style="text-align: center;">
                            <div id="actions">
                                <a title="edit" href="<?=URL::base()?><?=$role?>/achievementteachers/edit/<?=$teacher->teacher_id.
                                            '&'.$year.'&'.$record->id?>">
                                    <button class="action-button" value="">
                                        <img src="<?=URL::base()?>laguadmin/images/icons/pencil_gray.png">
                                    </button>
                                </a>
                                <button name="delete" value="<?=$teacher->teacher_id.'&'.$year.'&'.$record->id?>" data-toggle="modal" href="#deleteAchievementModal" 
                                        class="action-button achievement_delete_button">
                                    <a  href="#" title="Delete">
                                        <img src="<?=URL::base()?>laguadmin/images/icons/trashcan_gray.png">
                                    </a>
                                </button>
                            </div>
                        </td>
                    <? endif?>
                </tr>
                <?php endforeach; ?>
            <tbody>
        </table>
</div>
<div style="display: none;" class="modal hide" id="deleteAchievementModal">
    <div class="tac">
        <form action="<?=URL::base()?><?=$role?>/achievementteachers/delete" method="post">
            <input id="delete_achievement" type="hidden" name="delete_achievement" value="" />
            <p class="sepH_b">Are you sure you want to delete the achievement record?</p>
            <button type="submit" id="clear_yes" class="btn btn_d sepV_a">Yes</button>
            <button id="clear_no" class="btn btn_a" data-dismiss="modal">No</button >
        </form>
    </div>
</div>