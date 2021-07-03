Chart.defaults.global.defaultFontFamily= 'googlesans-regular';

var ctx = document.getElementById('compy_revenue').getContext('2d');
var chart = new Chart(ctx, { 
    type: 'line', 
    data: {
        labels: ['3 May', '4 May', '5 May', '6 May', '7 May', '8 May', '9 May'],
        datasets: [{
            label: 'Company1',
            fill:false,
            lineTension:0,
            backgroundColor: '#7d61dc',
            borderColor: '#7d61dc', 
            data: [0, 1, 11, 35, 18, 13, 19]
        },
        {
            label: 'Company2',
            fill:false,
            lineTension:0,
            borderColor: '#00b3b3',
            backgroundColor: '#00b3b3', 
            data: [9, 12, 8, 2, 9, 28, 21]
        },
        {
            label: 'Company3',
            fill:false,
            lineTension:0,
            backgroundColor: '#e3ab53',
            borderColor: '#e3ab53',  
            data: [20, 11, 29, 18, 27, 21, 8]
        },
        {
            label: 'Company4',
            fill:false,
            lineTension:0,
            backgroundColor: '#d17171',
            borderColor: '#d17171', 
            data: [32, 29, 25, 10, 50, 30, 32]
        }]
    }, 
    options: {
        legend: {
            display: true,
            labels: {
                boxWidth: 12, 
                fontSize: 12,
                fontColor: '#666',
                
            },

            position: "bottom" 
        }, 
        scales: {
			yAxes: [{
				scaleLabel: {
					display: true,
					labelString: 'Trip Revenue'
				}
            }],
            xAxes: [{
                gridLines: {
                    display:false
                }
            }],
        
        }
        
    }
}); 

var ctx = document.getElementById('dri_revenue').getContext('2d');
var chart = new Chart(ctx, { 
    type: 'line', 
    data: {
        labels: ['3 May', '4 May', '5 May', '6 May', '7 May', '8 May', '9 May'],
        datasets: [{
            label: 'Trip Count',
            fill:false,
            lineTension:0.5,
            backgroundColor: '#4773aa',
            borderColor: '#4773aa',
            data: [100, 110, 210, 430, 280, 230, 290],
            yAxisID: 'first-y-axis'
        },
        {
            label: 'Revenue',
            fill:false,
            lineTension:0.5,
            borderColor: '#00b3b3',
            backgroundColor: '#00b3b3',
            data: [21, 28, 9, 1, 8, 12, 9],
            yAxisID: 'second-y-axis'
        }]
    }, 
    options: {
        legend: {
            display: true,
            labels: {
                boxWidth: 12, 
                fontSize: 12,
                fontColor: '#666',
                verticalAlign: "center",
                         
            },

            position: "bottom" 
        }, 
        scales: {
			yAxes: [ 
				 
                {
                    id: 'first-y-axis',
                    type: 'linear',
                    position: 'left',
                    scaleLabel: {
                        display: true,
                        labelString: 'Amount'
                    }
                }, {
                    id: 'second-y-axis',
                    type: 'linear',
                    position: 'right',
                    gridLines: {
                        display:false,                        
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Trip Count'
                    }
                }
           ],

             
            xAxes: [{
                gridLines: {
                    display:false,
                    
                }
                
            }],
        
        }
    }
});


var ctx = document.getElementById('day_wise_trip').getContext('2d');
var chart = new Chart(ctx, { 
    type: 'bar', 
    data: {
        labels: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
        datasets: [{
            label: 'Trip Count',  
            backgroundColor: ['#5d9cec', '#54a6c4', '#4fc1e9', '#d17171', '#e3ab53', '#00b3b3', '#be8ade'], 
            data: [8, 18, 28, 18, 32, 25, 18]
        }]
    }, 
    options: {
        legend: false,
        scales: {
			yAxes: [{
				scaleLabel: {
					display: true,
					labelString: 'Jobs'
				}
            }],
            xAxes: [{
                gridLines: {
                    display:false
                },barPercentage: 0.6
            }],
        }
    }
});


var ctx = document.getElementById('dri_reject').getContext('2d');
var chart = new Chart(ctx, { 
    type: 'bar', 
    data: {
        labels: ['Driver 1', 'Driver 2', 'Driver 3', 'Driver 4', 'Driver 5'],
        datasets: [{
            label: 'Trip Count',
            backgroundColor: ['#5d9cec', '#54a6c4', '#4fc1e9', '#d17171', '#e3ab53', '#00b3b3', '#be8ade'],  
            data: [8, 18, 28, 18, 32]
        }]
    }, 
    options: {
        legend: false,
        scales: {
			yAxes: [{
				scaleLabel: {
					display: true,
					labelString: 'Counts'
				}
            }],
            xAxes: [{
                gridLines: {
                    display:false
                },barPercentage: 0.5
            }],    
        }
    }
});


var ctx = document.getElementById('driver').getContext('2d');
var chart = new Chart(ctx, { 
    type: 'bar', 
    data: { 
        labels: ['Driver 1', 'Driver 2', 'Driver 3', 'Driver 4', 'Driver 5'],
        datasets: [{
            label: 'Trip Count',
            backgroundColor: ['#5d9cec', '#4fc1e9', '#54a6c4', '#d17171', '#e3ab53', '#00b3b3', '#be8ade'],  
            data: [18, 40, 15, 32]
        }]
    }, 
    options: {
        legend: false, 
        scales: {
			yAxes: [{
				scaleLabel: {
					display: true,
					labelString: 'Jobs'
				}
            }],
            xAxes: [{
                gridLines: {
                    display:false
                },barPercentage: 0.4
            }],
        }
    }
});


var ctx = document.getElementById('trip_city').getContext('2d');
var chart = new Chart(ctx, { 
    type: 'doughnut', 
    data: {
       
        datasets: [{
            
            backgroundColor: [
                "#54a6c4", "#6798f1", "#7785f0"
            ],
            data: [60, 20, 20],
        }], 
        labels: ["New York", "Los Angeles", "San Antonio"] 
    }, 

    options: {
        cutoutPercentage:70, 
        legend:{
            position:'bottom',
            labels: {
                boxWidth: 9, 
                fontSize: 12,
                fontColor: '#666',
                usePointStyle: true,             
            },
        }}
});


var ctx = document.getElementById('city_emergency_alert').getContext('2d');
var chart = new Chart(ctx, { 
    type: 'doughnut',  
    data: { 
        datasets: [{ 
            backgroundColor: [
                "#54a6c4", "#6798f1", "#7785f0"
            ],
            data: [60, 20, 20],
        }], 
        labels: ["New York", "Los Angeles", "San Antonio"] 
    }, 

    options: {
        cutoutPercentage:70, 
        legend:{
            position:'bottom',
            labels: {
                boxWidth: 9, 
                fontSize: 12,
                fontColor: '#666',
                usePointStyle: true,             
            },
        }}
});


var ctx = document.getElementById('customers').getContext('2d');
var chart = new Chart(ctx, { 
    type: 'doughnut', 
    data: { 
        datasets: [{ 
            backgroundColor: [
                "#6798f1", "#4773aa" 
            ],
            data: [60, 40],
        }], 
        labels: ["Active Customers", "Inactive Customers" ] 
    }, 

    options: {
        cutoutPercentage:70, 
        legend:{position:'bottom',
        labels: {
            boxWidth: 9, 
            fontSize: 12,
            fontColor: '#666',
            usePointStyle: true,             
        },
    }}
});


var ctx = document.getElementById('pay_compy').getContext('2d');
var chart = new Chart(ctx, { 
    type: 'pie', 
    data: {
       
        datasets: [{
            borderWidth:2,
            backgroundColor: [
                "#e4888b", "#fbdb88", "#7cb287", "#4773aa", "#5fc7e3"
            ],
            data: [15, 20, 30, 20, 15],
        }], 
        labels: ["Cash Payment", "Credit card payment", "New card payment", "Promotion Payments", "Wallet Payments" ] 
    }, 

    options: { 
        legend:{
            position:'bottom',
            labels: {
                boxWidth: 9, 
                fontSize: 12,
                fontColor: '#666',
                usePointStyle: true,   
                      
            },
        }
    }
});

var ctx = document.getElementById('city_miss_book').getContext('2d');
var chart = new Chart(ctx, { 
    type: 'pie', 
    data: {
       
        datasets: [{
            borderWidth:2,
            backgroundColor: [
                "#e4888b", "#fbdb88", "#7cb287", "#4773aa", "#5fc7e3"
            ],
            data: [15, 20, 30, 20, 15],
        }], 
        labels: ["New York", "Los Angeles ",  "Chicago", "Houston", "Columbus"]  
    }, 

    options: { 
        legend:{position:'bottom',
        labels: {
            boxWidth: 9, 
            fontSize: 12,
            fontColor: '#666',
            usePointStyle: true,            
        },
}}
});
 


var ctx = document.getElementById('assign_vs_unassign').getContext('2d');
var chart = new Chart(ctx, { 
    type: 'bar', 
    data: { 
        labels: ['3 May', '4 May', '5 May', '6 May', '7 May', '8 May', '9 May'],
        datasets: [
            
              {
                label: "Total Fleets",
                yAxis: 'bar-stack',
                backgroundColor: "#54a6c4", 
                borderWidth: 0,
                stack: 'bef',
                data: [30, 50, 60, 70,30, 50, 60, 70]
              },
              {
                label: "Assigned fleets",
                yAxis: 'bar-stack',
                backgroundColor: "#7785f0", 
                borderWidth: 0,
                stack: 'bef',
                data: [40, 70, 30, 60, 100,70,40,60]
              },
              {
                label: "Total drivers",
                yAxis: 'bar-stack',
                backgroundColor: "#a0d0cb", 
                borderWidth: 0,
                stack: 'now',
                data: [100,70,40,60,90,70,60,40]
              },
              {
                label: "Assigned drivers",
                yAxis: "bar-stack",
                backgroundColor: "#bbc2f7",  
                borderWidth: 0,
                stack: 'now',
                data: [60,90,70,30,100,70,20,20]
              }
          ]
        }, 
    options: {
       
        legend: {
            display: true,
            labels: {
                boxWidth: 12, 
                fontSize: 12,
                fontColor: '#666',
                verticalAlign: 'end',
                
            },

            position: "bottom" 
        }, 
          scales: {
			yAxes: [{
				scaleLabel: {
					display: true,
                    labelString: 'Jobs', 
                    fontSize: 12,
                    fontColor: '#666'
				}
            }],
            xAxes: [{
                gridLines: {
                    display:false
                }
            }],
        }
           
    }
});
 



var ctx = document.getElementById('compy_wise_trip').getContext('2d');
var chart = new Chart(ctx, { 
    type: 'bar', 
    data: { 
        labels: ['3 May', '4 May', '5 May', '6 May', '7 May', '8 May', '9 May'],
        datasets: [
            
              {
                label: "Total Fleets",
                yAxis: 'bar-stack',
                backgroundColor: "#5d9cec", 
                borderColor: '#fff',
                
                stack: 'bef',
                data: [30, 50, 60, 70,30, 50, 60, 70]
              },
              {
                label: "Assigned fleets",
                yAxis: 'bar-stack',
                backgroundColor: "#4fc1e9", 
                borderColor: '#fff',
                
                stack: 'bef',
                data: [40, 70, 30, 60, 100,70,40,60]
              },
              {
                label: "Assigned fleets",
                yAxis: 'bar-stack',
                backgroundColor: "#54a6c4", 
                borderColor: '#fff',
                 
                stack: 'bef',
                data: [40, 70, 30, 60, 100,70,40,60]
              },
               
          ]
        }, 

    options: {
       
        legend: {
            display: true,
            labels: {
                boxWidth: 12, 
                fontSize: 12,
                fontColor: '#666',
                         
            },

            position: "bottom" 
        }, 
          scales: {
			yAxes: [{
				scaleLabel: {
					display: true,
					labelString: 'Jobs'
				}
            }],
            xAxes: [{
                gridLines: {
                    display:false
                },barPercentage: 0.6
            }]
        }
    }
});
 
 
