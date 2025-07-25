<template>
  <div class="min-h-screen bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg p-8">
      <h1 class="text-3xl font-bold text-blue-700 mb-6 text-center">📝 To-Do List</h1>

      <!-- Task Form -->
      <form @submit.prevent="addTask" class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Title</label>
          <input
            v-model="title"
            type="text"
            placeholder="e.g. Buy groceries"
            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
            required
          />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Description</label>
          <textarea
            v-model="description"
            placeholder="Optional description..."
            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
          ></textarea>
        </div>
        <button
          type="submit"
          class="w-full bg-blue-600 text-white py-2 rounded-md font-semibold hover:bg-blue-700 transition-all duration-200 shadow-sm"
        >
          ➕ Add Task
        </button>
      </form>

      <!-- Divider -->
      <hr class="my-8 border-t border-gray-200" />

      <!-- Task List -->
      <h2 class="text-xl font-semibold mb-4 text-gray-800">🗂 Latest Tasks</h2>

      <div v-if="tasks.length === 0" class="text-center text-gray-500">
        <p class="text-sm">You’re all caught up! 🎉</p>
      </div>

      <div
        v-for="task in tasks"
        :key="task.id"
        class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-4 shadow-sm hover:shadow-md transition"
      >
        <div class="flex justify-between items-center">
          <div>
            <h3 class="text-lg font-medium text-gray-900">{{ task.title }}</h3>
            <p class="text-sm text-gray-600" v-if="task.description">{{ task.description }}</p>
          </div>
          <button
            @click="markDone(task.id)"
            class="text-green-600 hover:text-green-800 text-sm font-semibold"
          >
            ✔ Done
          </button>
        </div>
      </div>
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
      axios.get('/tasks').then(res => this.tasks = res.data)
    },
    addTask() {
      if (!this.title.trim()) return
      axios.post('/tasks', {
        title: this.title.trim(),
        description: this.description.trim()
      }).then(() => {
        this.title = ''
        this.description = ''
        this.fetchTasks()
      })
    },
    markDone(id) {
      axios.patch(`/tasks/${id}/complete`).then(() => this.fetchTasks())
    }
  },
  mounted() {
    this.fetchTasks()
  }
}
</script>
