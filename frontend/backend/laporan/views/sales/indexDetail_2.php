<?php
$this->registerCss("
    .divTable
    {
        display:  table;
        width:auto;
        background-color:#eee;
        border:1px solid  #666666;
        border-spacing:5px;/*cellspacing:poor IE support for  this*/
       /* border-collapse:separate;*/
    }

    .divRow
    {
       display:table-row;
       width:auto;
    }

    .divCell
    {
        float:left;/*fix for  buggy browsers*/
        display:table-column;
        width:200px;
        background-color:#ccc;
    }



")
?>
<body>
  <form id="form1">
      <div class="divTable">
             <div class="headRow">
                <div class="divCell" align="center">Customer ID</div>
                <div  class="divCell">Customer Name</div>
                <div  class="divCell">Customer Address</div>
             </div>
            <div class="divRow">
                  <div class="divCell">001</div>
                <div class="divCell">002</div>
                <div class="divCell">003</div>
            </div>
            <div class="divRow">
                <div class="divCell">xxx</div>
                <div class="divCell">yyy</div>
                <div class="divCell">www</div>
           </div>
            <div class="divRow">
                <div class="divCell">ttt</div>
                <div class="divCell">uuu</div>
                <div class="divCell">Mkkk</div>
           </div>

      </div>
  </form>
</body>