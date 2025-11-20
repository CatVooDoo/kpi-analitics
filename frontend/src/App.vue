<template>
  <div class="dashboard">
    <header class="header">
      <h1> Сотрудники</h1>
      <p>Список всех сотрудников компании</p>
    </header>

    <!-- Загрузка -->
    <div v-if="loading" class="loading">
      <div class="spinner"></div>
      <p>Загрузка сотрудников...</p>
    </div>

    <!-- Ошибка -->
    <div v-else-if="error" class="error">
      <p> {{ error }}</p>
      <button @click="loadEmployees">Попробовать снова</button>
    </div>

    <!-- Список сотрудников -->
    <div v-else class="employees">
      <div v-for="employee in employees" :key="employee.id" class="employee-card">
        <img :src="employee.avatar" :alt="employee.name">
        <div class="info">
          <h3>{{ employee.name }}</h3>
          <p class="position">{{ employee.position }}</p>
          <p class="email" v-if="employee.email"> {{ employee.email }}</p>
          <div class="stats">
            <span>{{ employee.tasksCount }} задач</span>
            <span>{{ employee.reportsCount }} отчётов</span>
            <span>{{ employee.completionRate }}% выполнено</span>
            <span>{{ employee.testRate }}% test</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const loading = ref(true)
const error = ref(null)
const employees = ref([])

const loadEmployees = async () => {
  loading.value = true
  error.value = null

  try {
    const response = await axios.get('http://develop.luxecorp.ru/local/api/dev/backend/index.php?resource=employees')

    console.log('API Response:', response.data)

    if (response.data.success) {
      employees.value = response.data.data
    } else {
      error.value = response.data.message || 'Ошибка загрузки данных'
    }
  } catch (err) {
    console.error('Ошибка API:', err)
    error.value = 'Не удалось загрузить сотрудников: ' + err.message
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  loadEmployees()
})
</script>

<style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.dashboard {
  min-height: 100vh;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  padding: 40px 20px;
}

.header {
  text-align: center;
  color: white;
  margin-bottom: 40px;
}

.header h1 {
  font-size: 42px;
  margin-bottom: 8px;
}

.header p {
  font-size: 18px;
  opacity: 0.95;
}

.loading {
  text-align: center;
  color: white;
  padding: 60px;
}

.spinner {
  width: 50px;
  height: 50px;
  border: 5px solid rgba(255, 255, 255, 0.3);
  border-top-color: white;
  border-radius: 50%;
  margin: 0 auto 20px;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

.loading p {
  font-size: 18px;
}

.error {
  text-align: center;
  color: white;
  padding: 60px;
}

.error p {
  font-size: 20px;
  margin-bottom: 20px;
}

.error button {
  background: white;
  color: #667eea;
  border: none;
  padding: 12px 24px;
  border-radius: 8px;
  font-size: 16px;
  font-weight: 600;
  cursor: pointer;
  transition: transform 0.2s;
}

.error button:hover {
  transform: scale(1.05);
}

.employees {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
  gap: 24px;
  max-width: 1400px;
  margin: 0 auto;
}

.employee-card {
  background: white;
  border-radius: 16px;
  padding: 24px;
  display: flex;
  gap: 20px;
  align-items: flex-start;
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s, box-shadow 0.3s;
}

.employee-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
}

.employee-card img {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  object-fit: cover;
  border: 4px solid #667eea;
}

.info {
  flex: 1;
}

.info h3 {
  font-size: 20px;
  color: #2c3e50;
  margin-bottom: 6px;
}

.position {
  font-size: 14px;
  color: #7f8c8d;
  margin-bottom: 8px;
}

.email {
  font-size: 13px;
  color: #3498db;
  margin-bottom: 16px;
}

.stats {
  display: flex;
  flex-direction: column;
  gap: 8px;
  font-size: 13px;
  color: #7f8c8d;
}

.stats span {
  background: #f8f9fa;
  padding: 6px 12px;
  border-radius: 6px;
}

@media (max-width: 768px) {
  .employees {
    grid-template-columns: 1fr;
  }

  .header h1 {
    font-size: 32px;
  }

  .employee-card {
    flex-direction: column;
    align-items: center;
    text-align: center;
  }
}
</style>