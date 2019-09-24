<?php
if($ptnr) {
	switch($ptnr->ptnr_type)
	{
		case 11:
			$ptnr_type = "1000 대리점";
			break;
		case 13:
			$ptnr_type = "3000 대리점";
			break;
		case 15:
			$ptnr_type = "5000 대리점";
			break;
			
	}
}


?>
<style>
    .list{float:left;}
</style>
<div class="keyword_view">
	<table class="tb_st_01">
		<tr>
			<th>추천인 정보</th>
			<td><? echo $ptnr->prnts_ptnr_name."(".$ptnr->prnts_ptnr_mp.")"; ?></td>
	 	
			<th>대리점휴대폰</th>
			<td><?=numberToDash($ptnr->ptnr_mp)?></td>
	 	
			<th>대리점명</th>
			<td><?=$ptnr->ptnr_name?></td>
	 
			<th>사업자번호</th>
			<td><?=$ptnr->ptnr_co_no?></td>
	 	</tr>
	 	<tr>
			<th>mbr_code4</th>
			<td><?=$ptnr->mbr_code4?></td>
	 	
			<th>레벨</th>
			<td><?=$ptnr->gen_level?></td>
	 	
			<th>ID</th>
			<td><?=$ptnr->mbr_id?></td>
	 
			<th>사업자구분</th>
			<td><?=$ptnr_type?></td>
	 	</tr>
	 	<tr>
			<th>우편번호</th>
			<td><?=$ptnr->ptnr_zip5?></td>
	 
			<th>주소</th>
			<td><?=$ptnr->ptnr_addr1?></td>
	 
			<th>상세주소</th>
			<td colspan='3'><?=$ptnr->ptnr_addr2?></td>
	 	</tr>
	 	<tr>
			<th>은행명</th>
			<td><?=getbankInfo('getName', $ptnr->ptnr_bank_code)?></td>
	 	
			<th>계좌번호</th>
			<td><?=$ptnr->ptnr_acct_no?></td>
	 	
			<th>예금주</th>
			<td><?=$ptnr->ptnr_acct_name?></td>
	 
			<th>계좌확인일</th>
			<td><?=$ptnr->ptnr_acct_cfm_date?></td>
	 	</tr>
	 	<tr>
			<th>등록일자</th>
			<td><?=$rgst_date?></td>
	 	
			<th>등록일 일련번호</th>
			<td><?=$ptnr->rgst_date_serno?></td>
	 	
			<th>대리점키워드</th>
			<td><?=$ptnr->ptnr_keyword?></td>
	 
			<th>탈퇴일</th>
			<td><?=$ptnr->delete_date?></td>
	 	</tr>
	 	<tr>
			<th>메모</th>
			<td colspan='7'><?=$ptnr->memo?></td>
	 	</tr>
	 </table>
	 <p></p>
	 <div class="list" style="margin-right:15px;">
		<div class="control-group">
			<div class="controls">
			  <a href="/ptnr/ptnr_list/<?=$page?>" class="btn">리스트</a>
            </div>
		</div>
     </div>
	</div class="list">
         <div class="control-group">
             <div class="controls">
                 <a href="/ptnr/ptnr_treegrid" class="btn">계보도</a>
             </div>
         </div>
    </div>

