<template>
  <div class="register-page h-auto p-5">
    <img src="/img/energeek.png" class="mb-4 mt-5" />
    <div class="register-box">
      <div class="card rounded-lg">
        <div class="card-body">
          <p class="login-box-msg h4">Apply Lamaran</p>

          <form @submit.prevent="handleFormPost">
            <div class="form-group">
              <label for="username" class="fw-normal">Nama Lengkap</label>
              <input
                type="text"
                :class="{
                  'form-control': true,
                  'border-danger': validationErrors.username.length,
                }"
                id="username"
                placeholder="Cth: Jhonatan Akbar"
                required
                v-model="formData.username"
                @input="validateInput('username')"
              />
              <div v-show="validationErrors.username" class="text-danger">
                {{ validationErrors.username }}
              </div>
            </div>
            <div for="jabatan" class="form-group">
              <label class="fw-normal">Jabatan</label>
              <Select2
                v-model="formData.jabatanValue"
                :options="initialFormData.jabatanOptions"
                placeholder="Pilih Jabatan"
                id="jabatan"
                name="jabatan"
                class="w-auto"
                required
              />
            </div>
            <div class="form-group">
              <label for="telepon" class="fw-normal">Telepon</label>
              <input
                type="text"
                :class="{
                  'form-control': true,
                  'border-danger': validationErrors.telepon,
                }"
                id="telepon"
                placeholder="Cth: 0893239851289"
                required
                v-model="formData.telepon"
                @input="validateInput('telepon')"
              />
              <div v-show="validationErrors.telepon" class="text-danger">
                {{ validationErrors.telepon }}
              </div>
            </div>
            <div class="form-group">
              <label for="email" class="fw-normal">Email</label>
              <input
                type="email"
                :class="{
                  'form-control': true,
                  'border-danger': validationErrors.email,
                }"
                id="email"
                placeholder="Cth: energeekmail@gmail.com"
                required
                v-model="formData.email"
                @input="validateInput('email')"
              />
              <div v-show="validationErrors.email" class="text-danger">
                {{ validationErrors.email }}
              </div>
            </div>
            <div class="form-group">
              <label class="fw-normal">Tahun Lahir</label>
              <VueDatePicker
                v-model="formData.year"
                year-picker
                :year-range="[1970, 2024]"
                :required="true"
              />
            </div>
            <div class="form-group">
              <label for="skill" class="fw-normal">Skill Set</label>
              <Select2
                v-model="formData.skillValue"
                :options="initialFormData.skillOptions"
                :settings="{ multiple: true, allowClear: true }"
                placeholder="Pilih Skill"
                id="skill"
                name="skill"
                required
              />
            </div>
            <div class="d-grid">
              <button type="submit" class="btn btn-danger">Apply</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<style>
Poppins {
  font-family: Poppins-Black;
}
</style>

<script>
import Select2 from "vue3-select2-component";
import axios from "axios";

export default {
  components: { Select2 },
  data() {
    return {
      initialFormData: {
        jabatanOptions: [],
        skillOptions: [],
      },
      formData: {
        username: "",
        email: "",
        telepon: "",
        jabatanValue: "",
        skillValue: [],
        year: "",
      },
      validationErrors: {
        username: "",
        email: "",
        telepon: "",
      },
    };
  },
  name: "Form",
  beforeMount() {
    this.getInitialData();
  },
  methods: {
    async getInitialData() {
      try {
        const response = await axios.get("http://localhost:8000/api/form");

        if (response.status !== 201)
          return console.error("Gagal terhubung ke api:" + response.error);

        this.initialFormData.jabatanOptions = response.data.jobs.map((job) => ({
          text: job.name,
          id: job.id,
        }));

        this.initialFormData.skillOptions = response.data.skills.map(
          (skill) => ({
            text: skill.name,
            id: skill.id,
          })
        );
      } catch (error) {
        console.error(error.message);

        return this.$swal({
          title: "Terjadi Kesalahan!",
          text: error.message,
          icon: "error",
          confirmButtonText: "Baiklah",
        });
      }
    },
    validateInput(field) {
      const value = this.formData[field];
      let errorMessage = "";

      switch (field) {
        case "username":
          if (!/^[a-zA-Z\s]+$/.test(value)) {
            errorMessage =
              "Nama Lengkap hanya boleh mengandung huruf dan spasi";
          }
          break;
        case "email":
          if (!value.includes("@") || !value.includes(".")) {
            errorMessage = "Email tidak valid";
          }
          break;
        case "telepon":
          if (!/^\d+$/.test(value)) {
            errorMessage = "Telepon hanya boleh mengandung angka";
          }
          break;
      }
      this.validationErrors[field] = errorMessage;
    },
    async handleFormPost() {
      try {
        const hasErrors = Object.values(this.validationErrors).some(
          (error) => error !== ""
        );

        if (hasErrors) {
          // Jika field dalam form ada yang tidak valid, gagalkan submit
          return;
        }

        const response = await axios.post("http://localhost:8000/api/form", {
          name: this.formData.username,
          email: this.formData.email,
          phone: this.formData.telepon,
          year: this.formData.year,
          job_id: this.formData.jabatanValue,
          skills: this.formData.skillValue,
        });

        if (response.status !== 201)
          return console.error("Terjadi kesalahan:" + response.error);

        this.formData = {
          username: "",
          telepon: "",
          email: "",
          jabatanValue: "",
          skillValue: [],
          year: "",
        };

        return this.$swal({
          title: "Berhasil!",
          text: "Lamaran berhasil dikirim.",
          icon: "success",
          confirmButtonText: "Selesai",
        });
      } catch (error) {
        console.error(error);

        return this.$swal({
          title: "Terjadi Kesalahan!",
          text: error.response.data.message
            ? error.response.data.message
            : error.message,
          icon: "error",
          confirmButtonText: "Baiklah",
        });
      }
    },
  },
};
</script>
