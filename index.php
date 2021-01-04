<?php
if(isset($_POST['submit'])){
    $name=isset($_POST['city'])?$_POST['city']:'';
    
    // lat ,long
    $handle = curl_init();
    $url= "http://api.openweathermap.org/data/2.5/forecast?q=".$name."&appid=1c9f66ca3cef9fc28af0cd4bc8e09522&units=metric";
    curl_setopt($handle, CURLOPT_URL, $url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($handle);
    $arr1 =  json_decode($output);
    curl_close($handle);
    
    //weather calculation

    $handle = curl_init();
    $url= "https://api.openweathermap.org/data/2.5/onecall?lat=".$arr1->city->coord->lat."&lon=".$arr1->city->coord->lon."&exclude=minutely,hourly&appid=1c9f66ca3cef9fc28af0cd4bc8e09522&units=metric";
    curl_setopt($handle, CURLOPT_URL, $url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($handle);
    $arr =  json_decode($output);
    curl_close($handle);
    date_default_timezone_set("Asia/Kolkata");
    
    //echo "<pre>";
    // print_r($arr);
   
}

if(isset($_POST['cord'])){
    $lat=isset($_POST['lat'])?$_POST['lat']:'';

    $long=isset($_POST['long'])?$_POST['long']:'';

    $handle = curl_init();
    $url= "https://api.openweathermap.org/data/2.5/onecall?lat=".$lat."&lon=".$long."&exclude=minutely,hourly&appid=1c9f66ca3cef9fc28af0cd4bc8e09522&units=metric";
    curl_setopt($handle, CURLOPT_URL, $url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($handle);
    $arr =  json_decode($output);
    curl_close($handle);
    date_default_timezone_set("Asia/Kolkata");
     //echo "<pre>";
    // print_r($arr);
}
//Calculate Quater of the day//
function quater() {
    $date=date("G");
    $quater=   $date/6;
    return  ceil($quater);

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/v4-shims.min.js"
        integrity="sha512-fBnQ7cKP6HMwdVNN5hdkg0Frs1NfN7dgdTauot35xVkdhkIlBJyadHNcHa9ExyaI2RwRM7sBhoOt4R8W6lloBw=="
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script>
    $(document).ready(function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
            //console.log(position.coords.latitude);
        } else {
            console.log("NO")
        }

        function showPosition(position) {
            $('#lat').val(position.coords.latitude);
            $('#loc').val(position.coords.longitude);
            console.log(position.coords.latitude);
        }
    });
    </script>
</head>

<body>
    <div class="main content-center">
        <div class="col-lg-12 bg-dark p-5 text-center">
            <p class="h1 text-primary mb-4"><i class="fa fa-snowflake-o" aria-hidden="true"></i>Weather data</p>
            <form class="form-inline col-lg-6 mx-auto" action="index.php" method="POST">
                <div class="form-group mx-auto">
                    <input type="text" name="city" placeholder="City Name" pattern="^[a-zA-Z]+(?:[\s-][a-zA-Z]+)*$"
                        class="form-control" required>
                    <input type="submit" name="submit" class="btn btn-primary ml-4" value="FORECAST">
                </div>
            </form>
            <h3 class="text-white mt-2">OR</h3>
            <form class="form-inline col-lg-6 mx-auto mt-2" action="index.php" method="POST">
                <div class="form-group mx-auto">
                    <input type="text" name="lat" id="lat" placeholder="City Name" class="form-control" required hidden >
                    <input type="text" name="long" id="loc" placeholder="City Name" class="form-control" required hidden>
                    <input type="submit" name="cord" class="btn btn-primary ml-4" value="Use On Current Location">
                </div>
            </form>
        </div>
        <div class="container mx-auto">
            <?php if(isset($_POST['submit']) || isset($_POST['cord'])) {  ?>
            <div class="row-lg-12 text-center bg-dark text-primary mt-4">
                <p class="h2 "><?php if(isset($_POST['submit'])){
                    echo strtoupper($name);
                }?></p>
            </div>
            <div class="row mx-auto ">
                <?php foreach ($arr->daily as $key=>$data) { ?>
                <div class="card  bg-primary m-4 mx-auto text-white p-2">
                    <div class="card-body">
                        <p class="h6 card-text"><?php echo date('l F\'y, d', $data->dt  ); ?></p>
                        <hr>
                        <p class="h2 card-text">
                            <?php if(quater()==1) {echo $data->temp->morn."<sup>o</sup>C   Morning"; } else if(quater()==2){echo $data->temp->day."<sup>o</sup>C  Afternoon "; } else if(quater()==3){echo $data->temp->eve."<sup>o</sup>C   Evening"; } else if(quater()==4) { echo $data->temp->night."<sup>o</sup>C Night"; }?></a>
                        </p>(RealFeel <?php echo $data->feels_like->day ?><sup>o</sup>C)</a>
                        <p class="h5 card-text"><?php echo $data->weather[0]->main;?>
                            (<?php echo $data->weather[0]->description;?>)</p>
                        <img src="http://openweathermap.org/img/w/<?php echo $data->weather[0]->icon; ?>.png"
                            class="weather-icon" />
                        <hr>

                        <p class="h2 mt-2 card-text"><?php echo "Temprature";?>(<sup>o</sup>C)</a></p>
                        <p class="h6  card-text">Morning <?php echo $data->temp->morn ?><sup>o</sup>C</a>
                            <span class="ml-5">Day <?php echo $data->temp->day ?><sup>o</sup>C</a></span>
                        </p>

                        <p class="h6 card-text">Evening <?php echo $data->temp->eve ?><sup>o</sup>C</a>
                            <span class="ml-5"> Night <?php echo $data->temp->night ?><sup>o</sup>C</a></span>
                        </p>

                        <p class="h5 card-text">Min <span
                                class="h6"><?php echo $data->temp->min ; ?><sup>o</sup>C</span>
                            <span class="ml-5 "> Max <span class="h6"><?php echo $data->temp->max ; ?><sup>o</sup>C
                        </p>
                        <hr>
                        <p class="h5 card-text">Pressure <span
                                class="h6 text-right ml-5"><?php echo $data->pressure." mbar"; ?></span></p>
                        <p class="h5 card-text">Humidity <span
                                class="h6 text-right ml-5"><?php echo $data->humidity."%" ; ?></span></p>
                        <p class="h5 card-text">Wind Speed <span
                                class="h6 text-right ml-5"><?php echo $data->wind_speed." m/s" ; ?></span></p>
                        <hr>
                        <p class="h4 mt-2 card-text"><?php echo "Important Events";?></a></p>
                        <p class="h5 card-text"> Sunrise <span
                                class="h6 text-left ml-5"><?php echo date('h:i:sa', $data->sunrise  ); ?></spna>
                        </p>
                        <h5 class="">Sunset<span
                                class="text-left h6 ml-5"><?php echo date('h:i:sa', $data->sunset  ); ?></span></h5>
                    </div>
                </div>
                <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
</body>

</html>