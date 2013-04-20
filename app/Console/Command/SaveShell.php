<?php
class SaveShell extends AppShell {

	public $uses = array('Issue','Status','User');

	public function main(){

		//issueの登録
		$issue_option = array();
		//コマンドの引数をIssue.nameとして保存する
		$issue_option['name'] = isset($this->args[0]) ? $this->args[0] : '';
		$this->Issue->create();
		$this->Issue->save($issue_option);


		//ひたすら保存する処理
		while($row = $this->stdin->read()){
			if($tmp_obj= json_decode($row)){

				//statusの保存
				$status_option = array(
					'status_id'=>$tmp_obj->id,
					'created_at'=>$tmp_obj->created_at,
					'source'=>$tmp_obj->source,
					'in_reply_to_status_id'=>$tmp_obj->in_reply_to_status_id,
					'in_reply_to_user_id'=>$tmp_obj->in_reply_to_user_id,
					'user_id'=>$tmp_obj->user->id,
					'status_text'=>$tmp_obj->text,
					'status_json'=>$row,
					'issue_id'=>$this->Issue->id,
				);
				$this->Status->create();
				$this->Status->save($status_option);

				//userの保存(INSERT xor UPDATE)
				$tmp_obj->user;
				$user_option = array('user_id'=>$tmp_obj->user->id,
														 'screen_name'=>$tmp_obj->user->screen_name,
														 'user_json'=>json_encode($tmp_obj->user));
				if($user_data = $this->User->find('first',array(
																						'conditions'=>array(
																							'User.user_id'=>$tmp_obj->user->id
																						)))){
					$this->User->id = $user_data['User']['id'];
				}else{
					//登録がなければINSERT
					$this->User->create();
				}
				$this->User->save($user_option);
			}
		}

	}
}
