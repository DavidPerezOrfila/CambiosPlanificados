$(document).ready(function() {
  $("tr").each(function() {
    $(this).children("td").each(function() {
      switch ($(this).html()) {
        case 'cancelled':
          $(this).css("background-color", "#f26419");
          $(this).html("Cancelado");
          break;
        case 'closed':
          $(this).css("background-color", "#758e4f");
          $(this).html("Cerrado");
          break;
        case 'initial':
          $(this).css("background-color", "#86bbd8");
          $(this).html("Iniciado");
          break;
      }
    })
  })

  $(".cierre").each(function() {
    $(this).each(function() {
      switch ($(this).html()) {
        case '1':
          $(this).css("background-color", "#758e4f");
          $(this).html("Exitoso");
          break;
        case '2':
          $(this).css("background-color", "#86bbd8");
          $(this).html("Exitoso con problemas");
          break;
        case '4':
          $(this).css("background-color", "#f6ae2d");
          $(this).html("Rechazado");
          break;
        case '6':
          $(this).css("background-color", "#f26419");
          $(this).html("Cancelado");
          break;
      }
    })
  })

  $(".riesgo").each(function() {
    $(this).each(function() {
      switch ($(this).html()) {
        case '0':
          $(this).css("background-color", "#FFF");
          $(this).html("Sin Riesgo");
          break;
        case '1':
          $(this).css("background-color", "#758e4f");
          $(this).html("Bajo");
          break;
        case '2':
          $(this).css("background-color", "#86bbd8");
          $(this).html("Algún Riesgo");
          break;
        case '3':
          $(this).css("background-color", "#f6ae2d");
          $(this).html("Moderado");
          break;
        case '4':
          $(this).css("background-color", "#f26419");
          $(this).html("Alto");
          break;
      }
    })
  })
});
