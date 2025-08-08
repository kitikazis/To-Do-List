document.addEventListener('DOMContentLoaded', () => {

  document.querySelectorAll('.animated').forEach((el, index) => {
    setTimeout(() => {
      el.classList.add('visible');
    }, 300 + index * 300);
  });
});


function expandirCelda(celda) {
  const yaExpandida = document.querySelector('.dia-celda.expanded');
  if (yaExpandida && yaExpandida !== celda) {
    yaExpandida.classList.remove('expanded');
  }
  celda.classList.toggle('expanded');
}

function mostrarResumen() {
  const actividades = document.querySelectorAll('.actividad-mini');
  const resumen = {};

  actividades.forEach(act => {
    const titulo = act.querySelector('.titulo')?.textContent || 'Sin título';
    const fecha = act.closest('.dia-celda')?.querySelector('.dia-header')?.textContent || 'Sin fecha';
    if (!resumen[fecha]) resumen[fecha] = [];
    resumen[fecha].push(titulo);
  });

  let salida = 'Resumen de actividades:\n\n';
  for (const fecha in resumen) {
    salida += `${fecha}:\n`;
    resumen[fecha].forEach(t => salida += `  • ${t}\n`);
    salida += '\n';
  }

  alert(salida);
}