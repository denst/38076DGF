<div id="tab-1">
    <div id="subject-block">
        <?php if(count($subjects) > 0): ?>
        <table cellpadding="0" cellspacing="0" border="0" class="table_a smpl_tbl">
            <thead>
                <tr>
                    <th><div class="th_wrapp">#</div></th>
                    <th><div class="th_wrapp">Name</div></th>
                    <th><div class="th_wrapp">Parent Subject</div></th>
                    <th><div class="th_wrapp">Actions</div></th>
                </tr>
            </thead>
            <tbody>
            <? $index = 0;?>
            <?php foreach ($subjects as $subject): ?>
              <? $index++;?>
              <tr>
                  <td><?=$index?></td>
                  <td><?php echo $subject->name ?></td>
                  <td>-</td>
                  <td>
                      <div id="actions">
                          <a href="<?php echo URL::base() ?><?=$role?>/subjects/edit/<?php echo $subject->id ?>" class="sepV_a" title="Edit">
                            <button class="action-button">
                              <img src="<?=URL::base()?>laguadmin/images/icons/pencil_gray.png" alt="" />
                            </button>
                          </a>
                          <button name="delete" value="<?=$subject->id?>" data-toggle="modal" href="#deleteSubjectModal" 
                                class="action-button subject_delete_button">
                            <a href="" title="Delete">
                              <img src="<?=URL::base()?>laguadmin/images/icons/trashcan_gray.png" alt="" />
                            </a>  
                          </button>
                      </div>
                  </td>
              </tr>
              <?php $subjects_childrs = ORM::factory('subject')->where('pid', '=', $subject->id)->find_all() ?>
              <?php if(count($subjects_childrs) > 0): ?>
                  <?php foreach($subjects_childrs as $subject_childr): ?>
                    <? $index++;?>
                      <tr>
                          <td><?=$index?></td>
                          <td><?php echo $subject_childr->name ?></td>
                          <td><?php echo $subject->name ?></td>
                          <td>
                              <div id="actions">
                                  <a href="<?php echo URL::base() ?><?=$role?>/subjects/edit/<?php echo $subject_childr->id ?>" class="sepV_a" title="Edit">
                                    <button class="action-button">
                                        <img src="<?=URL::base()?>laguadmin/images/icons/pencil_gray.png" alt="" />
                                    </button>
                                  </a>
                                  <button name="delete" value="<?=$subject_childr->id?>" data-toggle="modal" href="#deleteSubjectModal" 
                                    class="action-button subject_delete_button">
                                    <a href="" title="Delete">
                                      <img src="<?=URL::base()?>laguadmin/images/icons/trashcan_gray.png" alt="" />
                                    </a>  
                                  </button>
                              </div>
                          </td>
                      </tr>
                  <?php endforeach; ?>
              <?php endif; ?>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
            <p>The subjects are not found</p>
        <?php endif; ?>
    </div>
</div>
<br/>
<a href="<?=URL::base()?><?=$role?>/subjects/create">
    <button type="submit" class="btn btn_dL sepH_b">Create Subject</button>
</a>
<div style="display: none;" class="modal hide" id="deleteSubjectModal">
    <div class="tac">
        <form action="<?=URL::base()?><?=$role?>/subjects/delete" method="post">
            <input id="delete_subject_id" type="hidden" name="subject_id" value="" />
            <p class="sepH_b">Are you sure you want to delete subject?</p>
            <button type="submit" id="clear_yes" class="btn btn_d sepV_a">Yes</button>
            <button id="clear_no" class="btn btn_a" data-dismiss="modal">No</button >
        </form>
    </div>
</div>