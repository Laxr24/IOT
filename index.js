const axios = require("axios")

const SerialPort = require("serialport")

// Update your port location for MAC or Windows OS, simply run "npx @serialport/list"
const port = new SerialPort("Serial Port", {
    baudRate: 9600,
    // autoOpen: false
})

var speed, light;

function fetchUpdate() {
    axios.get("http://127.0.0.1:8000/api").then(res => {
        //    Do something after getting the data 
        speed = res.data.fan;
        light = res.data.light;

       console.log(re.data.data)


    }).catch(err => {
        console.log(err)
    })

    // port.write('H'); 
}

setInterval(fetchUpdate, 1000)