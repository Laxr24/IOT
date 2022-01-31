const axios = require("axios")

const SerialPort = require("serialport")

// Update your port location for MAC or Windows OS, simply run "npx @serialport/list"
let macPort = "/dev/tty.usbmodemFA13401"
let pcPort = "COM3"
const port = new SerialPort(pcPort, {
    baudRate: 9600,
    // autoOpen: false
})

var speed, light, cmd;
var localLink = "http://127.0.0.1:8000"; 
var webLink = "https://www.ishwardy.com"; 
function control(){
    axios.get(`${webLink}/api`).then((res)=>{
        speed = res.data.fan
        light = res.data.light
        cmd = res.data.cmd 

        if(cmd != ""){
            if(cmd != null){
                port.write(cmd)
            }
            console.log(cmd)
            axios.post(`${webLink}/iot`, {
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