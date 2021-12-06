<!doctype html>

<html lang="en">
<head>
<style>
.mdl-card__media {
background: white;  
 width: 400px;

}
.closebtn {
    float: right;
    color: white;
    font-size: 35px;
    cursor: pointer;
}

</style>
</head>
<body>
<div class="mdl-grid">
<?php for ($i=0; $i < count($template); $i++) { ?>
  <div class="mdl-cell mdl-cell--4-col mdl-card__media">
    <div class="mdl-card mdl-shadow--2dp">
      <div class="mdl-card__title">
        <h2 class="mdl-card__title-text"><?php echo $template[$i]->itemp_title; ?></h2>
      </div>
      <div class="mdl-card__supporting-text">
        <button class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect choose_btn" id="<?php echo 'ch'.$template[$i]->itemp_id; ?>">Choose</button>
        <div id="<?php echo 'mod'.$template[$i]->itemp_id; ?>" >
          <div class="mdl-textfield mdl-js-textfield">
            <input type="text" class="mdl-textfield__input temp_text" id="<?php echo 't'.$i; ?>">
            <label class="mdl-textfield__label" for="<?php echo 't'.$i; ?>">Type of pages you want for this template</label>
          </div>
          <button class="mdl-button mdl-js-button mdl-button--fab mdl-button--colored temp_btn" id="<?php echo $i; ?>"><i class="material-icons">add</i></button>
          <table class="mdl-data-table mdl-js-data-table temp_table" id="<?php echo 'tb'.$i; ?>" style="width: 100%;scroll-behavior: auto; overflow: auto;" border="0">
            <thead>
              <tr>
                <th class="mdl-data-table__cell--non-numeric">Type</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php if(isset($selected_template)) {
                for ($j=0; $j < count($selected_template); $j++) { }
              } ?>
            </tbody>  
          </table>
        </div>
      </div>
    </div>
  </div>
<?php }
?> 
</div>
<div class="mdl-cell mdl-cell--4-col">
    <button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="submit"><i class="material-icons">done</i></button>
  </div>
</body>
</html>

<script type = "text/javascript">
  var temp_array = [], tempid = "";
  $(document).ready(function(){
    // $('.collapse').hide();

    <?php if(isset($selected_template)) {
      for ($j=0; $j < count($selected_template); $j++) { 
        echo 'temp_array.push("'.$selected_template[$j]->iutc_copies.'"); tempid = '.$selected_template[$j]->iutc_temp_id.';';
      }
      for($j=0; $j<count($template);$j++) {
        if($selected_template[0]->iutc_temp_id == $template[$j]->itemp_id) {
          echo "addtolist('#tb".$j." > tbody'); $('#mod".$selected_template[0]->iutc_temp_id."');";
          break;
        }
      }
    }?>
    $('.choose_btn').click(function(e) {
      e.preventDefault();

      temp_array = [];
      $('.temp_table > tbody').empty();
      // $('.collapse').hide(500);
      tempid = $(this).prop('id').toString();
      var b = tempid.substring(2, tempid.length);
      tempid = b;
      var c = '#mod' + b;
    })

    $('.temp_btn').click(function(e) {
      e.preventDefault();
      var a=$(this).prop('id');
      var ab = '#t' + a;
      temp_array.push($(ab).val());
      addtolist('#tb'+a+' > tbody');
      $(ab).val('');
      $(ab).focus();
    });

    $('table').on('click', '.tbl_delete', function(e) {
      e.preventDefault();
      temp_array.splice($(this).prop('id'), 1);
      var a=$(this).prop('id');
      var ab = '#t' + a;
      addtolist('#tb'+a+' > tbody');
      $(ab).val('');
      $(ab).focus();
     console.log($(this).prop('id'));
    });
});

function addtolist(table) {
  $(table).empty(); var out="";
  for (var i = 0; i < temp_array.length; i++) {
      out+='<tr><td class="mdl-data-table__cell--non-numeric">'+temp_array[i]+'</td><td><button class="mdl-button mdl-js-button mdl-button--icon tbl_delete" id="' + i + '"><i class="material-icons">delete</i></button></td></tr>';
     }
  $(table).append(out);
}

$('#submit').click(function(){
      $.ajax({
        url: "<?php echo base_url().'Account/change_template/'.$mod_id; ?>",
        type: 'POST',
        data: {'id' : tempid, 'arr' : temp_array},
        success: function(data) {
            window.location.href = "<?php echo base_url().'Account/module_setting'; ?>";  
        }
   });
   return false;
});

</script>

