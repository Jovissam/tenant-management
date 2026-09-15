<template>
  <div class="loader-backdrop">
    <div class="loader-dialog" role="dialog" aria-modal="true">
      <div class="loader">
        <span></span>
        <span></span>
        <span></span>
      </div>

      <p>Loading...</p>
    </div>
  </div>
</template>

<style scoped>
.loader-backdrop {
  position: fixed;
  inset: 0;
  z-index: 9999;

  display: flex;
  align-items: center;
  justify-content: center;

  background: rgba(15, 23, 42, 0.55);
  backdrop-filter: blur(0);
}

.loader-dialog {
  width: 140px;
  min-height: 120px;

  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 18px;

  padding: 24px;

  background: #ffffff;
  border-radius: 16px;

  box-shadow:
    0 20px 40px rgba(0, 0, 0, 0.15),
    0 5px 15px rgba(0, 0, 0, 0.08);
}

.loader {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 7px;
}

.loader span {
  width: 9px;
  height: 9px;

  border-radius: 50%;
  background: #4f46e5;

  animation: bounce 1.2s infinite ease-in-out;
}

.loader span:nth-child(1) {
  animation-delay: -0.24s;
}

.loader span:nth-child(2) {
  animation-delay: -0.12s;
}

.loader span:nth-child(3) {
  animation-delay: 0s;
}

p {
  margin: 0;

  color: #475569;
  font-size: 14px;
  font-weight: 500;
}

@keyframes bounce {
  0%,
  80%,
  100% {
    transform: scale(0.6);
    opacity: 0.5;
  }

  40% {
    transform: scale(1);
    opacity: 1;
  }
}
</style>