var base_url=$('#base_url').val();
$(document).ready(function () {


	var classSideBar=$(".classSideBar").attr('id');
	var classId=classSideBar.substring(7);


	getClassMarksheet(classId);/*Ketu kemi thirrur funksioni me posht dmth ne ready function ne menyr automatike thirret ky funksion*/

});
/*Funksioni per shfaqejn e te dhenav duke u bazur ne class id ku te dhenat jan sectoret
 * dhe per me shum informacion vazhdoni shiqoni funksonin  */
function getClassMarksheet(classId=null) {
	/*Ketu eshte nje funksion i cili premse ajax ekzekuton nje komand ne section modul dhe rezultatin e shfaq ne classen result
	* e cila eshte ne section view ku premes keti funksioni i e realizoim komanden dhe ja dergoim classId i cila specifikon clasen
	* dhe sectionet te cilat jan ne te dmth gjdo gje se eshte mrena kesaj klass id na shfaqet ne rezult me ndryshe sectionet te cilat e kan classid
	* adekuate ne shfaqen ketu*/
	if(classId){

		$.ajax({
			url:base_url+'marksheet/fetchMarksheetTable/'+classId,
			type:'post',
			success:function (response) {
				$(".result").html(response);

			}
		});
	}

}
