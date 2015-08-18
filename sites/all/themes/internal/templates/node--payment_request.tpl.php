<article id="article-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>

  <?php print $unpublished; 
  $declined = field_get_items('node', $node, 'field_declined');
  if(isset($declined[0]['nid'])) {
		print "<span style = 'color: red;'>This form has been declined. Review the 'Payment Request Discrepancy Form' section for more information. <br>To make changes please click the 'Resubmit' button</span>";
	}
  ?>

  <?php if(!empty($user_picture) || !$page || (!empty($submitted) && $display_submitted)): ?>
    <header class="clearfix<?php $user_picture ? print ' with-picture' : ''; ?>">

      <?php print $user_picture; ?>
      
      <?php print render($title_prefix); ?>
      <?php if ($title): ?>
       <!-- <h1<?php print $title_attributes; ?>>
          <a href="<?php print $node_url; ?>" rel="bookmark"><?php print $title; ?></a>
        </h1> -->
      <?php endif; ?>
      <?php print render($title_suffix); ?>
	  
	  <?php if ($tabs = render($tabs)): ?><div class="hiddentabs"><?php print $tabs; ?></div><?php endif; ?>

      <?php if ($display_submitted): ?>
        <div class="submitted"><?php print $submitted; ?></div>
      <?php endif; ?>

    </header>
  <?php endif; ?>

  <div<?php print $content_attributes; ?>>
  <?php
    hide($content['comments']);
    hide($content['links']);
    print render($content);
  ?>
  <?php 
	//Determining whether form has been approved by anyone
	$dept_appr = field_get_items('node', $node, 'field_appr_dept_head');
	$acct_appr = field_get_items('node', $node, 'field_appr_adv');
	$dir_appr = field_get_items('node', $node, 'field_appr_director');
	$treas_appr = field_get_items('node', $node, 'field_appr_treasurer');
	$vp_appr = field_get_items('node', $node, 'field_appr_vp');
	$approved = false;
	if(isset($dept_appr)) {
		if($dept_appr[0]['value'] == 1) {
			$approved = true;
		}
	}elseif(isset($acct_appr)) {
		if($acct_appr[0]['value'] == 1) {
			$approved = true;
		}
	}elseif(isset($dir_appr)) {
		if($dir_appr[0]['value'] == 1) {
			$approved = true;
		}
	}elseif(isset($treas_appr)) {
		if($treas_appr[0]['value'] == 1) {
			$approved = true;
		}
	}elseif(isset($vp_appr)) {
		if($vp_appr[0]['value'] == 1) {
			$approved = true;
		}
	}
  ?>
  <div id = "approval_buttons" >
  <?php
	//print 'Declined: <pre>'.print_r($declined, true).'</pre>';

	$nid = $node->nid;	
	if(isset($declined[0]['nid'])) {
	//show 'Resubmit' button if form has been declined
		print "<a href='/resubmit-payreq/$nid' title = 'Resubmit this form with changes' ><input id='resubmit_payreq' class='form-submit' type='submit' name='resubmit_payreq' value='Resubmit' /></a>";
	}else{
		$status = field_get_items('node', $node, 'field_payreq_status');
		
		if((in_array('drupal admin', $user->roles)||
			in_array('Accountant', $user->roles)||
			in_array('Advancement Admin', $user->roles)||
			in_array('AS Director', $user->roles)||
			in_array('Department Head', $user->roles)||
			in_array('Treasurer', $user->roles)||
			in_array('VP for Ext. Relations/Uni. Advancement', $user->roles)
		  )) {
			
			//Approve button is visible to anyone in an approval role, unless form has been declined.
			print "<a href='/node/$nid/edit' title = 'Edit Approval for this form' ><input id='approve_payreq' class='form-submit' type='submit' name='approve_payreq' value='Approve' /></a>";
			
			//Decline button is visible to approvers if form is still in approval process and hasn't already been declined
			if($status != 'Paid' && $status != 'Ready for Payment' && $status != 'Declined') {
				print "<a href='/node/add/payment-request-discrepancy-form/$nid' title = 'Decline Approval and file a Payment Request Discrepancy form' >".
						"<input id='decline_payreq' class='form-submit' type='submit' name='decline_payreq' value='Decline' />".
					  "</a>";
			}
		}
	 
		/* COMMENTED OUT SINCE WE'RE REMOVING ABILITY OF AUTHORS TO EDIT
		 * Edit button is visible to node author before approval, unless form has been declined.
		if($approved == false && $node->uid == $user->uid) {
			print "<a href='/node/$nid/edit' title='Edit Payment Request information' ><input id='edit_payreq' class='form-submit' type='submit' name='edit_payreq' value='Edit' /></a>";
		}
		*/
	}

  ?>
  </div> <!-- end Approval Buttons div -->
  </div>

  <?php if ($links = render($content['links'])): ?>
    <nav class="clearfix"><?php print $links; ?></nav>
  <?php endif; ?>

  <?php print render($content['comments']); ?>

</article>
