//Pseudo code
//Step 1: Define chart properties.
//Step 2: Create the chart with defined properties and bind it to the DOM element.
//Step 3: Add the CandleStick Series.
//Step 4: Set the data and render.
//Step5 : Plug the socket to the chart


//Code
const log = console.log;

const chartProperties = {
  width:1500,
  height:600,
  leftPriceScale: {
	visible: true,
  timeScale:{
    timeVisible:true,
    secondsVisible:false,
  }
}
}

const domElement = document.getElementById('tvchart');
const chart = LightweightCharts.createChart(domElement,chartProperties);
const candleSeries = chart.addCandlestickSeries();


fetch(`http://127.0.0.1:9665/fetchAPI?endpoint=https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY&symbol=GOOG&interval=1min&outputsize=full&apikey=J3EXAX2537WRHC`)
  .then(res => res.json())
  .then(data => {
    const cdata = data.map(d => {
      return {open:parseFloat(d[1]),high:parseFloat(d[2]),low:parseFloat(d[3]),close:parseFloat(d[4])}
    });
    candleSeries.setData(cdata);
  })
  .catch(err => log(err))

//Dynamic Chart
const socket = io.connect('http://127.0.0.1:4000/');

socket.on('KLINE',(pl)=>{
  //log(pl);
  candleSeries.update(pl);
});
