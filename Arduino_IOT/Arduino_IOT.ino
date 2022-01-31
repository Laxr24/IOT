#include <TimerOne.h>  // Avaiable from http://www.arduino.cc/playground/Code/Timer1
volatile int i=0;               // Variable to use as a counter
volatile boolean zero_cross=0;  // Boolean to store a "switch" to tell us if we have crossed zero
int FAN = 3;   // Output to Opto Triac
int LIGHT = 7; // Relay-1
int dim = 128;  // Dimming level (0-128)  0 = on, 128 = 0ff
int pas = 14;   // step for count;
int freqStep = 75;   // This is the delay-per-brightness step in microseconds.
char BTData; // incoming data from serial Bluetooth)
void setup() {  // Begin setup
  Serial.begin(9600); // initialization
  pinMode(FAN, OUTPUT);  // Set the Triac pin as output
  pinMode(LIGHT, OUTPUT); // Set the Relay pin as output
                     
  attachInterrupt(0, zero_cross_detect, RISING);    // Attach an Interupt to Pin 2 (interupt 0) for Zero Cross Detection
  Timer1.initialize(freqStep);                      // Initialize TimerOne library for the freq we need
  Timer1.attachInterrupt(dim_check, freqStep);      
  // Use the TimerOne Library to attach an interrupt
}
void zero_cross_detect() {    
  zero_cross = true;     // set the boolean to true to tell our dimming function that a zero cross has occured
  i=0;
  digitalWrite(FAN, LOW);
}                                 
// Turn on the TRIAC at the appropriate time
void dim_check() {                   
  if(zero_cross == true) {              
    if(i>=dim) {                     
      digitalWrite(FAN, HIGH);  // turn on light       
      i=0;  // reset time step counter                         
      zero_cross=false;    // reset zero cross detection
    } 
    else {
      i++;  // increment time step counter                     
    }                                
  }    
}                                      
void Wireless()
{
    if(Serial.available()){
     BTData = Serial.read(); // read byte
    if(BTData == 'a') {if(dim<127){dim = dim + pas; if(dim>127) {dim=128;}}} // Step DOWN
    if(BTData == 'A') {if(dim>5){dim = dim - pas;   if(dim<0)   {dim=0;}}}   // Step UP
    if(BTData == 'B') {dim=0;}   // power is 100% (on)
    if(BTData == 'b') {dim=128;} // power is 0% (off)
    if(BTData == 'C') {digitalWrite(LIGHT, HIGH); } // LIGHT ON
    if(BTData == 'c') {digitalWrite(LIGHT, LOW); }  // LIGHT OFF
    }
}
void loop() {  
                                     
delay (100);
 Wireless();
}
