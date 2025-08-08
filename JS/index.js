document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.animated-section, .animated').forEach((el, index) => {
    setTimeout(() => {
      el.classList.add('visible');
    }, 300 + index * 300);
  });
});