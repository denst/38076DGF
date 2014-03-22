<div id="tab-3">
    <div class="sepH_c">
        <div id="user-block">
            <h1 class="sepH_c">Student Profile</h1>
            <div class="cf formEl sepH_b">
                <form id="imageform" method="post" enctype="multipart/form-data" action='<?=URL::base()?>ajax/ajaximage'>
                    <div class="dp33 tac">
                        <img id="img-polaroid" alt="" src="<?=(Valid::not_empty($user_data['image']))?
                            URL::base().'files/users/'.$user_data['student_id'].'/110x110/'.$user_data['image']: 
                            '/laguadmin/images/user_noPhoto100.gif'?>" />
                    </div>
                </form>

                <div class="formEl_a students-form"> 
                    <div class="dp60">
                            
                        <fieldset id="main-info">
                            <legend>Main info</legend>
                            <div class="sepH_b">
                                <label class="lbl_b">Studenst ID (Login) - <?=$user->username?></label>
                            </div>
                            <div class="sepH_b">
                                <label for="a_select" class="lbl_b">STUDENTS ADMISSION FORM FOR GRADES 1-12 ACADEMIC YEAR</label>
                                <select name="academic_year" id="a_select" disabled>
                                    <?php foreach($levels as $level): ?>
                                    <? if(isset($user_data)):?>
                                        <option value="<?php echo $level->id ?>" <?php echo $level->id == $user_data['academic_year'] ? 'selected' : '' ?>><?php echo $level->name ?></option>
                                    <? else:?>
                                        <option value="<?php echo $level->id ?>"><?php echo $level->name ?></option>
                                    <? endif?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>First Name/Father's Name/Grandfather's Name</legend>
                            <div class="sepH_b">
                                <label for="name" class="lbl_a">First Name:</label>
                                <div class="content"><?=(isset($user_data))? $user_data['name']: ''?></div>
                            </div>
                            <div class="sepH_b">
                                <label for="fathername" class="lbl_a">Father's Name:</label>
                                <div class="content"><?=(isset($user_data))? $user_data['fathername']: ''?></div>
                            </div>
                            <div class="sepH_b">
                                <label for="grfathername" class="lbl_a">Grandfather's Name:</label>
                                <div class="content"><?=(isset($user_data))? $user_data['grfathername']: ''?></div>
                            </div>
                        </fieldset>
                        
                        <fieldset>
                            <div id="email" class="sepH_b">
                                <label for="email" class="lbl_a">Email:</label>
                                <div class="content"><?=(isset($user_data))? $user_data['email']: ''?></div>
                            </div>
                        </fieldset>
                        
                        <fieldset>
                            <legend>Birthday/Sex</legend>
                            <div class="sepH_c cf">
                                <label for="datepick-1" class="lbl_a">Date of birth (E.C):</label>
                                <div class="content"><?=(isset($user_data))? $user_data['dob']['ec']: ''?></div>
                            </div>
                            <div class="sepH_c cf">
                                <label for="datepick-2" class="lbl_a">Date of birth (G.C):</label>
                                <div class="content"><?=(isset($user_data))? $user_data['dob']['gc']: ''?></div>
                            </div>
                            <div class="sepH_b">
                                <label for="sex" class="lbl_a" readonly="readonly">Sex:</label>
                                <select name="sex" id="a_select" disabled>
                                    <option value="0" <?=(isset($user_data) AND $user_data['sex'] == '0')? 'selected': ''?>>Male</option>
                                    <option value="1" <?=(isset($user_data) AND $user_data['sex'] == '1')? 'selected': ''?>>Female</option>
                                </select>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>Home Address</legend>
                            <div class="sepH_b">
                                <label for="address_kk" class="lbl_a">Kifle Ketema:</label>
                                <div class="content"><?=(isset($user_data))? $user_data['address']['kk']: ''?></div>
                            </div>
                            <div class="sepH_b">
                                <label for="address_k" class="lbl_a">Kebele:</label>
                                <div class="content"><?=(isset($user_data))? $user_data['address']['k']: ''?></div>
                            </div>
                            <div class="sepH_b">
                                <label for="address_h" class="lbl_a">House No.:</label>
                                <div class="content"><?=(isset($user_data))? $user_data['address']['h']: ''?></div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>Father Information</legend>
                            <div class="sepH_b">
                                <label for="father_name" class="lbl_a">Name:</label>
                                <div class="content"><?=(isset($user_data))? $user_data['father']['name']: ''?></div>
                            </div>
                            <div class="sepH_b">
                                <label for="father_occ" class="lbl_a">Occupation:</label>
                                <div class="content"><?=(isset($user_data))? $user_data['father']['occ']: ''?></div>
                            </div>
                            <div class="sepH_b">
                                <label for="father_pw" class="lbl_a">Place of work:</label>
                                <div class="content"><?=(isset($user_data))? $user_data['father']['pw']: ''?></div>
                            </div>
                            <fieldset class="phone-block">
                                <legend>Telephone</legend>
                                <div class="sepH_b">
                                    <label for="father_telephone_of" class="lbl_a">Office:</label>
                                    <div class="content"><?=(isset($user_data))? $user_data['father']['telephone']['of']: ''?></div>
                                </div>
                                <div class="sepH_b">
                                    <label for="father_telephone_m" class="lbl_a">Telephone:</label>
                                    <div class="content"><?=(isset($user_data))? $user_data['father']['telephone']['m']: ''?></div>
                                </div>
                                <div class="sepH_b">
                                    <label for="father_telephone_r" class="lbl_a">Residence:</label>
                                    <div class="content"><?=(isset($user_data))? $user_data['father']['telephone']['r']: ''?></div>
                                </div>
                            </fieldset>
                        </fieldset>

                        <fieldset>
                            <legend>Mother Information</legend>
                            <div class="sepH_b">
                                <label for="mother_name" class="lbl_a">Name:</label>
                                <div class="content"><?=(isset($user_data))? $user_data['mother']['name']: ''?></div>
                            </div>
                            <div class="sepH_b">
                                <label for="mother_occ" class="lbl_a">Occupation:</label>
                                <div class="content"><?=(isset($user_data))? $user_data['mother']['occ']: ''?></div>
                            </div>
                            <div class="sepH_b">
                                <label for="mother_pw" class="lbl_a">Place of work:</label>
                                <div class="content"><?=(isset($user_data))? $user_data['mother']['pw']: ''?></div>
                            </div>
                            <fieldset class="phone-block">
                                <legend>Telephone</legend>
                                <div class="sepH_b">
                                    <label for="mother_telephone_of" class="lbl_a">Office:</label>
                                    <div class="content"><?=(isset($user_data))? $user_data['mother']['telephone']['of']: ''?></div>
                                </div>
                                <div class="sepH_b">
                                    <label for="mother_telephone_m" class="lbl_a">Telephone:</label>
                                    <div class="content"><?=(isset($user_data))? $user_data['mother']['telephone']['m']: ''?></div>
                                </div>
                                <div class="sepH_b">
                                    <label for="mother_telephone_r" class="lbl_a">Residence:</label>
                                    <div class="content"><?=(isset($user_data))? $user_data['mother']['telephone']['r']: ''?></div>
                                </div>
                            </fieldset>
                        </fieldset>
                        
                        <fieldset>
                            <legend>Guardian Information</legend>
                            <div class="sepH_b">
                                <label for="guardian_name" class="lbl_a">Name:</label>
                                <div class="content"><?=(isset($user_data))? $user_data['guardian']['name']: ''?></div>
                            </div>
                            <div class="sepH_b">
                                <label for="guardian_rel" class="lbl_a">Relation to the student:</label>
                                <div class="content"><?=(isset($user_data))? $user_data['guardian']['rel']: ''?></div>
                            </div>
                            <div class="sepH_b">
                                <label for="guardian_pw" class="lbl_a">Place of work:</label>
                                <div class="content"><?=(isset($user_data))? $user_data['guardian']['pw']: ''?></div>
                            </div>
                            <fieldset class="phone-block">
                                <legend>Telephone</legend>
                                <div class="sepH_b">
                                    <label for="guardian_telephone_of" class="lbl_a">Office:</label>
                                    <div class="content"><?=(isset($user_data))? $user_data['guardian']['telephone']['of']: ''?></div>
                                </div>
                                <div class="sepH_b">
                                    <label for="guardian_telephone_m" class="lbl_a">Telephone:</label>
                                    <div class="content"><?=(isset($user_data))? $user_data['guardian']['telephone']['m']: ''?></div>
                                </div>
                            </fieldset>
                        </fieldset>

                        <fieldset>
                            <legend>Contacts telephones in case of emergency (give detailed information)</legend>
                            <div class="tels">
                                <?php foreach ($user_data['tels_em'] as $key => $tel): ?>
                                    <div class="group-field-block tel">
                                        <div class="sepH_b">
                                            <label class="lbl_a" for="tels_em_<?php echo $key ?>_name">Name:</label>
                                            <div class="content"><?php echo $tel['name'] ?></div>
                                        </div>
                                        <div class="sepH_b">
                                            <label class="lbl_a" for="tels_em_<?php echo $key ?>_tel">Tel. No.</label>
                                            <div class="content" ><?php echo $tel['tel'] ?></div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </fieldset>

                        <fieldset id="languages">
                            <legend>Languages spoken at home:</legend>
                            <div class="sepH_b">
                                <label for="languages_0" class="lbl_a">1:</label>
                                <div class="content"><?=(isset($user_data))? $user_data['languages']['0']: ''?></div>
                            </div>
                            <div class="sepH_b">
                                <label for="languages_1" class="lbl_a">2:</label>
                                <div class="content"><?=(isset($user_data))? $user_data['languages']['1']: ''?></div>
                            </div>
                            <div class="sepH_b">
                                <label for="languages_2" class="lbl_a">3:</label>
                                <div class="content"><?=(isset($user_data))? $user_data['languages']['1']: ''?></div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>Any health conditions that the school should know about:</legend>
                            <div class="sepH_b">
                                <label for="health" class="lbl_a">Please specify:</label>
                                <div>
                                    <? foreach ($user_data['health'] as $value):?>
                                        <div class="content health"><?=$value?></div>
                                    <? endforeach;?>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset id="brothers">
                            <legend>Does the applicant have any siblings (brothers or sisters) learning in Dandii Boru School? If yes give particulars:</legend>
                            <div class="siblings">
                                <?php foreach($user_data['siblings'] as $key => $sib): ?>
                                    <div class="group-field-block sib">
                                        <div class="sepH_b">
                                            <label for="siblings_<?php echo $key ?>_name" class="lbl_a">Name:</label>
                                            <div class="content"><?php echo $sib['name'] ?></div>
                                        </div>
                                        <div class="sepH_b">
                                            <label for="siblings_<?php echo $key ?>_grade" class="lbl_a">Grade & section:</label>
                                            <div class="content"><?php echo $sib['grade'] ?></div>
                                        </div>
                                        <div class="sepH_b">
                                            <label for="siblings_<?php echo $key ?>_rel" class="lbl_a">Relation:</label>
                                            <div class="content"><?php echo $sib['rel'] ?></div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>