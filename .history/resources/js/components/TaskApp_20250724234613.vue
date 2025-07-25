<template>
  <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">To-Do App</h1>

    <form @submit.prevent="addTask" class="space-y-4">
      <input v-model="title" type="text" placeholder="Title" required class="w-full px-3 py-2 border rounded" />
      <textarea v-model="description" placeholder="Description" class="w-full px-3 py-2 border rounded"></textarea>
      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add Task</button>
    </form>

    <h2 class="text-xl font-semibold mt-8 mb-4">Latest Tasks</h2>
    <div v-if="tasks.length === 0" class="text-gray-500">No pending tasks.</div>

    <div v-for="task in tasks" :key="task.id" class="bg-gray-50 p-4 mb-3 rounded border">
      <h3 class="text-lg font-medium">{{ task.title }}</h3>
      <p class="text-sm text-gray-600">{{ task.description }}</p>
      <button @click="markDone(task.id)" class="mt-2 text-sm text-green-600 hover:underline">Done</button>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      title: '',
      description: '',
      tasks: []
    }
  },
  methods: {
    fetchTasks() {
      axios.get('/tasks')
        .then(res => this.tasks = res.data)
    },
    addTask() {
      axios.post('/tasks', {
        title: this.title,
        description: this.description
      }).then(() => {
        this.title = '';
        this.description = '';
        this.fetchTasks();
      });
    },
    markDone(id) {
      axios.patch(`/tasks/${id}/complete`)
        .then(() => this.fetchTasks());
    }
  },
  mounted() {
    this.fetchTasks();
  }
}
</script>
