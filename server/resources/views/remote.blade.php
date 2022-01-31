<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>IOT Controller</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css"
        integrity="sha512-wnea99uKIC3TJF7v4eKk4Y+lMz2Mklv18+r4na2Gn1abDRPPOeef95xTzdwGD9e6zXJBteMIhZ1+68QC5byJZw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.25.0/axios.min.js"
        integrity="sha512-/Q6t3CASm04EliI1QyIDAA/nDo9R8FQ/BULoUFyN4n/BDdyIxeH7u++Z+eobdmr11gG5D/6nPFyDlnisDwhpYA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <style>
        .active {
            background-color: rgb(27, 221, 27);
        }

        .btn {
            padding: 6px 10px;
            border-radius: .3em;
            /* background-color: rgb(68, 68, 68); */
        }

    </style>
</head>

<body class="bg-gray-900 text-white font-mono text-center tracking-widest">
    <div class="max-w-md mx-auto bg-gray-700 rounded-lg h-full grid grid-cols-1 p-3 pb-6 mt-3">

        <h1 class="text-pink-700 bg-gray-900 p-2 rounded-md">IOT Test Remote</h1>
        {{-- Light Controller --}}
        <div class="my-3 flex justify-center items-center">
            <p class="pr-6">Direct control</p>
            <button class="light_btn btn">OFF</button>
        </div>

        {{-- Fan Controller --}}
        <div class="mt-3 bg-gray-800 rounded-full px-4 pb-5 pt-4">
            <p class="text-lg">Variable control</p>
            <div class="my-3 flex justify-center items-center">
                <button
                    class=" fan_btn_d px-8 mx-4 py-2 rounded-md bg-gradient-to-br from-yellow-500 to-yellow-700 my-1">-</button>
                <button
                    class=" fan_btn_i px-8 mx-4 py-2 rounded-md bg-gradient-to-br from-green-500 to-green-700 my-1">+</button>
            </div>
            <p class="fanSpeed inline">0</p><span>%</span>
        </div>
    </div>

    <script>
        var speed = 0 // current speed or power of the dimmer
        var light = true // True and Flase means on and off respectively
        var step = 10 //Step to inrease or decrease the dimmer value 

        var l_btn = document.querySelector(".light_btn")
        var btn_i = document.querySelector(".fan_btn_i")
        var btn_d = document.querySelector(".fan_btn_d")
        var fanSpeed = document.querySelector(".fanSpeed")

        btn_i.onclick = () => {
            // console.log("hi")
            if (speed >= 0 && speed < 100) {
                speed += step
                fanSpeed.innerHTML = speed
                axios.post("http://127.0.0.1:8000/iot", {
                    "fan": speed,
                    "light": light
                }).then((res) => {
                    console.log(res.data)
                })

            }
        }


        btn_d.onclick = () => {
            // console.log("hi")
            if (speed > 0 && speed <= 100) {
                speed -= step
                fanSpeed.innerHTML = speed

                axios.post("http://127.0.0.1:8000/iot", {
                    "fan": speed,
                    "light": light
                }).then((res) => {
                    console.log(res.data)
                })
            }
        }

        l_btn.onclick = () => {
            l_btn.classList.toggle("active")
            if (l_btn.innerHTML == "OFF") {
                light = true
                l_btn.innerHTML = "ON"
                axios.post("http://127.0.0.1:8000/iot", {
                    "fan": speed,
                    "light": light
                }).then((res) => {
                    console.log(res.data)
                })
            } else {
                light = false
                l_btn.innerHTML = "OFF"
                axios.post("http://127.0.0.1:8000/iot", {
                    "fan": speed,
                    "light": light
                }).then((res) => {
                    console.log(res.data)
                })
            }
        }


        // Executes document onload
        axios.get("http://127.0.0.1:8000/api").then((res) => {
            speed = res.data.fan 
            light = res.data.light 
            console.log(res.data)

            if(light){
                l_btn.classList.add("active")
                l_btn.innerHTML = "ON"
            }
            else{
                l_btn.classList.remove("active")
                l_btn.innerHTML = "OFF"
            }
            fanSpeed.innerHTML = speed
        }).catch((err)=>{
            console.log(err)
        })
    </script>

</body>

</html>
