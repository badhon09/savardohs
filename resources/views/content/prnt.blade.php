<style>
    body{
        margin: 20px 50px;
    }
    .flex-head{
        border: 2px dashed #000;
        padding: 25px 10px 10px 10px;
    }
    .flex-container {
        display: flex;
        flex-wrap: nowrap;
    }
    .flex-container > h2 {
        width: 100%;
        text-align: center;
    }
    .flex-container_txt  {
        width: 100%;
        text-align: center;
        margin:0px;
    }
    .online_text{
        background: #c0fff3;
        border: 2px dashed #000;
        -webkit-print-color-adjust: exact;
        padding: 5px;
        margin-top:25px;
        text-align: center;
        font-size: 25px;
    }
    .wordTk{
        border: 2px dashed #000;
        padding: 5px;
        margin-top:10px;
        font-size: 20px;
    }

    #item {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
        margin: 25px 0px 25px 0px;
    }

    #item td, #item th {
        border: 2px solid #000;
        padding: 8px;
    }

    #item th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: center;
        background-color: #c0fff3;
        -webkit-print-color-adjust: exact;
    }
</style>
<div style="text-align:center ; border-bottom:5px solid #000;padding-bottom:5px">
    <img src="{{asset('images/logo/logo.png')}}" alt="logo" height="100" width="100">
    <h2>Rajuk Uttara Model College</h2>
    <span>Rajuk Uttara Model College</span><br>
    <span>Rajuk Uttara Model College</span>
</div>
<h3 class="online_text">Online payment Receipt</h3>
<div class="flex-head">
    <div class="flex-container">
        <h4 style="text-align:left;margin:0px">Name</h4>
        <h4 class="flex-container_txt">Saimoom</h4>
        <h2></h2>
        <h4 style="text-align:left;margin:0px">Name</h4>
        <h4 class="flex-container_txt">Saimoom</h4>
        <h2></h2>
    </div>
    <div class="flex-container">
        <h4 style="text-align:left;margin:0px">Name</h4>
        <h4 class="flex-container_txt">Saimoom</h4>
        <h2></h2>
        <h4 style="text-align:left;margin:0px">Name</h4>
        <h4 class="flex-container_txt">Saimoom</h4>
        <h2></h2>
    </div>
</div>
<div>
    <table id="item">
        <tr>
            <th>Sl</th>
            <th>Company</th>
            <th>Contact</th>
            <th>Country</th>
        </tr>
        <tr>
            <td>1</td>
            <td>Alfreds Futterkiste</td>
            <td>Maria Anders</td>
            <td>Germany</td>
        </tr>
        <tr>
            <td>2</td>
            <td>Berglunds snabbköp</td>
            <td>Christina Berglund</td>
            <td>Sweden</td>
        </tr>
        <tr>
            <td>3</td>
            <td>Centro comercial Moctezuma</td>
            <td>Francisco Chang</td>
            <td>Mexico</td>
        </tr>
        <tr>
            <th colspan="3" style="text-align: right;">Total</th>
            <th>Amount</th>
        </tr>
    </table>
</div>
<h2 class="wordTk">
    In Words: Demo-1 Taka Only
</h2>
