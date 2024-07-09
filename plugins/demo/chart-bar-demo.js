// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

deportes_cant_pers_masculino();

function deportes_cant_pers_masculino() {
  var datos = new FormData();
  datos.append("accion", "reporte_deporte_masculino");

  $.ajax({
    url: "", // Agrega tu URL de endpoint aquí
    type: "POST",
    contentType: false,
    data: datos,
    processData: false,
    cache: false,
    success: (response) => {
      // Parsear la respuesta JSON
      var data = JSON.parse(response);

      // Extraer nombres de deportes y cantidad de personas
      var deportes = [];
      var cantidadPersonas = [];
      data[0].forEach(item => {
        deportes.push(item.nombre_deporte);
        cantidadPersonas.push(item.cantida_personas);
      });

      // Crear el gráfico con Chart.js
      var ctx = document.getElementById("myBarChart_masculino");
      var myLineChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: deportes,
          datasets: [{
            label: "Cantidad de Personas",
            backgroundColor: "rgba(2,117,216,1)",
            borderColor: "rgba(2,117,216,1)",
            data: cantidadPersonas.map(Number) // Convertir a números
          }],
        },
        options: {
          scales: {
            xAxes: [{
              time: {
                unit: 'month'
              },
              gridLines: {
                display: false
              },
              ticks: {
                maxTicksLimit: 6
              }
            }],
            yAxes: [{
              ticks: {
                min: 0,
                maxTicksLimit: 5
              },
              gridLines: {
                display: true
              }
            }],
          },
          legend: {
            display: false
          }
        }
      });
    },
    error: (err) => {
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Algo salió mal!',
      });
    },
  });
}

deportes_cant_pers_femenino();

function deportes_cant_pers_femenino() {
  var datos = new FormData();
  datos.append("accion", "reporte_deporte_femenino");

  $.ajax({
    url: "", // Agrega tu URL de endpoint aquí
    type: "POST",
    contentType: false,
    data: datos,
    processData: false,
    cache: false,
    success: (response) => {
      var data = JSON.parse(response);

      // Extraer nombres de deportes y cantidad de personas
      var deportes = [];
      var cantidadPersonas = [];
      data[0].forEach(item => {
        deportes.push(item.nombre_deporte);
        cantidadPersonas.push(item.cantida_personas);
      });

      // Crear el gráfico con Chart.js
      var ctx = document.getElementById("myBarChart_femenino");
      var myLineChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: deportes,
          datasets: [{
            label: "Cantidad de Personas",
            backgroundColor: "rgba(202,90,202,1)",
            borderColor: "rgba(2,117,216,1)",
            data: cantidadPersonas.map(Number) // Convertir a números
          }],
        },
        options: {
          scales: {
            xAxes: [{
              time: {
                unit: 'month'
              },
              gridLines: {
                display: false
              },
              ticks: {
                maxTicksLimit: 6
              }
            }],
            yAxes: [{
              ticks: {
                min: 0,
                maxTicksLimit: 5
              },
              gridLines: {
                display: true
              }
            }],
          },
          legend: {
            display: false
          }
        }
      });
    },
    error: (err) => {
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Algo salió mal!',
      });
    },
  });
}

