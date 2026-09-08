<template>
  <section>
    <div class="containerr">
        <div class="row">
          <div class="col-md-6">
            <div class="auth-layout flex-column all-flex">
              <div class="w-100 mb-5">
                <span class="title borderr">Tenaty</span>
              </div>
              <div class="auth-container w-100 all-flex flex-column">
                <!-- title slot -->
                <slot name="title"></slot>
                <!-- main slot -->
                <slot></slot>
              </div>

              <div class="d-flex justify-content-between mt-5 w-100">
                <!-- link slot -->
                <slot name="link"></slot>

                <p>Terms and Conditions</p>
              </div>
            </div>
          </div>
          <div class="col-md-6 bg-dager">
            <div class="image-control">
            </div>
          </div>
        </div>
    </div>
  </section>
</template>

<style scoped>
section {
    height: 100vh;
    width: 100vw;
  display: flex;
  justify-content: center;
  align-items: center;
}
.containerr {
  width: 85vw;
  background:linear-gradient(to bottom right,#E3E5E6, #EBE7D3, #F6E5B9, #FAEEB9);
  border-radius: 20px;
}
.auth-layout {
  height: 100%;
  padding: 20px;
}
.title {
  padding: 8px 20px;
  border-radius: 30px;
  font-weight: bold;
}

.image-control {
    height: 100%;
background: url(@/assets/images/banners/bg-1.jpg) no-repeat center/cover;
background-attachment: fixed;
border-radius: 0 20px 20px 0;
}
</style>