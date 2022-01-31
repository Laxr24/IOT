const axios = require("axios")

const SerialPort = require("serialport")

// Update your port location for MAC or Windows OS, simply run "npx @serialport/list"
// const port = new SerialPort("Serial Port", {
//     baudRate: 9600,
//     // autoOpen: false
// })

var speed, light, cmd;

function control(){
    axios.get("http://127.0.0.1:8000/api").then((res)=>{
        speed = res.data.fan
        light = res.data.light
        cmd = res.data.cmd 

        if(cmd != ""){
            console.log(cmd)
            axios.post("http://127.0.0.1:8000/iot", {
                "fan": speed,
                "light": light,
                "cmd":""
            }).then(res2=>{
                console.log(res2.data)
            }).catch(err=>{
                console.log(err)
            })
        }
    })
}

setInterval(control, 3000)