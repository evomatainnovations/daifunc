<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js"></script>
<style type="text/css">
    .chart-element {
        width: 225px;
        height: 225px;
    }
    .chart-element-new {
        width: 350px;
        height: 350px;
    }
</style>
<main class="mdl-layout__content">
	<div class="mdl-grid products">
        <?php for($i=0; $i < count($projects); $i++) {
            echo '<div class="mdl-cell mdl-cell--6-col mdl-shadow--4dp" id="'.$projects[$i]->iextpp_id.'"" style="text-align:center;border-radius: 15px;">';
            echo '<h2 style="font-size:2.5em;">'.$projects[$i]->iextpp_p_name.'</h2><hr style="width:70%;margin-left:15%;">';
            if (count($pro_act) > 0 ) {
                echo '<div class="mdl-grid"><div class="mdl-cell mdl-cell--4-col">';
                echo '<canvas id="ch'.$i.'" width="80" height="80"></canvas></div><div class="mdl-cell mdl-cell--8-col">';
                echo '<div class="mdl-grid">';
                echo '<h4>Progress activity</h4>';
                if (isset($act_list)) {
                    if (count($act_list) > 0 ) {
                        $c_flg = 1 ;
                        for ($ij=0; $ij < count($act_list) ; $ij++) {
                            if ($act_list[$ij]['pid'] == $projects[$i]->iextpp_id ) {
                                echo '<div class="mdl-cell mdl-cell--12-col"><h5 style="text-align:left;">'.$c_flg.' ) '.$act_list[$ij]['title'].'</h5>';
                                echo '</div>';
                                $c_flg++;
                            }else{
                                echo '<div class="mdl-cell mdl-cell--12-col"><h5 style="text-align:left;">Not found !</h5></div>';
                                break;
                            }
                        }
                    }
                }
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '<button class="mdl-button mdl-button--accent project_list" id="'.$projects[$i]->iextpp_id.'">View More</button>';
                $labels = [];
                $tmp_lbl = [];
                $values = [];
                for ($ij=0; $ij < count($pro_act) ; $ij++) {
                    if ($pro_act[$ij]['pid'] == $projects[$i]->iextpp_id ) {
                        array_push($labels , $pro_act[$ij]['status']);
                        array_push($values , $pro_act[$ij]['aid']);
                    }
                }
                $labels_str = json_encode($labels);
                $values_str = json_encode($values);
                if (count($pro_act) > 0) {
                    echo '<script>var ctx = document.getElementById("ch'.$i.'").getContext("2d");';
                    echo 'var myChart = new Chart(ctx, {type: "doughnut", data: {labels: '.$labels_str.', datasets: [{ label: "Project task", data: '.$values_str.', backgroundColor: ["#ff0000", "#999", "rgba(202, 200, 16, 0.79)","#800000", "#000"] }] }, options: { title : { display: true, text: "Group Status" } , rotation : -0.1 * Math.PI } });</script>';   
                }
            }else{
                echo '<button class="mdl-button mdl-button--accent project_list" id="'.$projects[$i]->iextpp_id.'">View More</button>';
            }
            echo '<hr style="width:70%;margin-left:15%;">';
            echo '<h4 style="font-size:1.5em;">'.$projects[$i]->iextpp_p_description.'</h4>';
            echo '</div>';
        } ?>
	</div>
    <?php 
        if(isset($userflow)) {
            if ($userflow == 'true') {
                echo '<button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="submit_project">';
                echo '<i class="material-icons">add</i>';
                echo '</button>';        
            }
	    }else{
                echo '<button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="submit_project">';
                echo '<i class="material-icons">add</i>';
                echo '</button>';
        }
    ?>
</main>
</div>

</body>
<script type="text/javascript">
    $(document).ready(function() {

        $('#fixed-header-drawer-exp').change(function(e) {
            $.post('<?php echo base_url()."Projects/search_projects/".$code; ?>', {
                'keywords' : $(this).val()
            }, function(data, status, xhr) {
                var abc = JSON.parse(data);

                $('#products > tbody').empty();

                var cust = abc.customer;
                var cust_out = "";

                $('#products > tbody').append(cust_out);

                console.log(data);
            }, "text");
        });
        
        $('.products').on('click','.project_list', function(e) {
            e.preventDefault();
            window.location = "<?php echo base_url().'Projects/edit_project_details/'.$code.'/'; ?>" + $(this).prop('id');
        });

        $('#submit_project').click(function(e) {
            e.preventDefault();
            window.location = "<?php echo base_url().'Projects/add_projects/'.$code; ?>";
        });

        var a_flg = 'false';
        
        $("#act_mail").change(function(){
            if($(this).prop("checked") == true){
                a_flg = 'true';
            }else{
                a_flg = 'false';
            }
        });

         $('#submit').click(function(e) {
            e.preventDefault();
            if($('#search_modal').css('display') != 'none'){
                var note = $('#notes_text').html();
                $('#ATags > li').each(function(index) {
                    var tmpstr = $(this).text();
                    var len = tmpstr.length - 1;
                    if(len > 0) {
                        tmpstr = tmpstr.substring(0, len);
                        activity_tags.push(tmpstr);
                    }
                });
                var date = $('.s_date').val();
                var e_date = $('.e_date').val();
                $.post('<?php echo base_url()."Home/notification_activity_update/".$code."/subscription/"; ?>'+amc_id, {
                    'a_title' : $('#a_title').val(),'a_date' : date,'a_place' : $('#a_place').val(),'a_person' : person_array,'a_to_do' : todo_array,'a_note' : $('#notes_text').val() ,'a_tags' : activity_tags ,'note' : note,'a_func_short' : $('#m_shortcuts').val(),'a_mail' : a_flg ,'e_date' : e_date,'a_cat' : $('#a_cat').val()
                }, function(data, status, xhr) {
                        location.reload();
                }, 'text');
            }
        });

    });
</script>
</html>