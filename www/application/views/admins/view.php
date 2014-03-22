<div class="sepH_c">
    <div id="user-block">
        <h1 class="sepH_c">Admin Profile</h1>
        <div class="cf formEl sepH_b">
            <div class="dp33 tac">
                <img id="img-polaroid" alt="" src="<?=(Valid::not_empty($user_data['image']))?
                    URL::base().'files/users/'.$user_data['admin_id'].'/110x110/'.$user_data['image']: 
                        '/laguadmin/images/user_noPhoto100.gif'?>" />
            </div>

            <? if(isset($register)):?>
            <form class="formEl_a admin-form" name="register_admin" 
                  action="<?php echo URL::base() ?>session/registeradmin" method="POST" >
            <? elseif(isset($edit)):?>
            <form class="formEl_a admin-form" name="edit_admin" 
                  action="<?php echo URL::base() ?><?=$role?>/admin/edit/<?php echo $user->id ?>" method="POST" >
            <? else:?>
            <form class="formEl_a admin-form" name="create_admin" 
                  action="<?php echo URL::base() ?><?=$role?>/admin/create" method="POST" >
            <? endif;?>
                <div class="dp60">
                    <fieldset id="main-info">
                        <legend>Main info</legend>
                        <div class="sepH_b">
                            <label class="lbl_b">Admin ID (Login) - <?=$user->username?></label>
                        </div>
                        <div class="sepH_b">
                            <label for="name" class="lbl_a">Role:</label>
                            <div class="content"><?=(isset($role))? $role: ''?></div>
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
                            <div class="content"><?=(isset($user_data))? $user_data['dob']: ''?></div>
                        </div>
                        <div class="sepH_b">
                            <label for="sex" class="lbl_a">Sex:</label>
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
                            <div class="content"><?=(isset($user_data))? $user_data['home_address']['kk']: ''?></div>
                        </div>
                        <div class="sepH_b">
                            <label for="address_k" class="lbl_a">Kebele:</label>
                            <div class="content"><?=(isset($user_data))? $user_data['home_address']['k']: ''?></div>
                        </div>
                        <div class="sepH_b">
                            <label for="address_h" class="lbl_a">House No.:</label>
                            <div class="content"><?=(isset($user_data))? $user_data['home_address']['h']: ''?></div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>Information about last job</legend>
                        <div class="sepH_b">
                            <label for="lpw" class="lbl_a">Last Place of work:</label>
                            <div class="content"><?=(isset($user_data))? $user_data['lpw']: ''?></div>
                        </div>
                        <div class="sepH_b">
                            <label for="job" class="lbl_a">Job Title:</label>
                            <div class="content"><?=(isset($user_data))? $user_data['job']: ''?></div>
                        </div>
                        <div class="sepH_b">
                            <label for="contact_name" class="lbl_a">Contact Name (Reference):</label>
                            <div class="content"><?=(isset($user_data))? $user_data['contact_name']: ''?></div>
                        </div>
                        <div class="sepH_b">
                            <label for="address" class="lbl_a">Address:</label>
                            <div class="content"><?=(isset($user_data))? $user_data['address']: ''?></div>
                        </div>
                        <fieldset class="phone-block">
                            <legend>Telephone</legend>
                            <div class="sepH_b">
                                <label for="telephone_of" class="lbl_a">Office:</label>
                                <div class="content"><?=(isset($user_data))? $user_data['telephone']['of']: ''?></div>
                            </div>
                            <div class="sepH_b">
                                <label for="telephone_m" class="lbl_a">Mobile:</label>
                                <div class="content"><?=(isset($user_data))? $user_data['telephone']['m']: ''?></div>
                            </div>
                        </fieldset>
                    </fieldset>

                    <fieldset>
                        <legend>Emergency information</legend>
                        <div class="sepH_b">
                            <label for="emergency_contact" class="lbl_a">Emergency Contact:</label>
                            <div class="content"><?=(isset($user_data))? $user_data['emergency']['contact']: ''?></div>
                        </div>
                        <div class="sepH_b">
                            <label for="emergency_relation" class="lbl_a">Relation to you:</label>
                            <div class="content"><?=(isset($user_data))? $user_data['emergency']['relation']: ''?></div>
                        </div>
                        <div class="sepH_b">
                            <label for="emergency_pw" class="lbl_a">Place of work:</label>
                            <div class="content"><?=(isset($user_data))? $user_data['emergency']['pw']: ''?></div>
                        </div>
                        <div class="sepH_b">
                            <label for="emergency_tm" class="lbl_a">Mobile:</label>
                            <div class="content"><?=(isset($user_data))? $user_data['emergency']['tm']: ''?></div>
                        </div>
                        <fieldset class="languages-block" id="languages">
                            <legend>Languages spoken:</legend>
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
                                <div class="content"><?=(isset($user_data))? $user_data['languages']['2']: ''?></div>
                            </div>
                        </fieldset>
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
                </div>
            </form>
        </div>
    </div>
</div>