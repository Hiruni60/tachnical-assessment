<template>
  <div class="min-h-screen bg-gray-100 flex items-center justify-center py-10 px-4">
    <div class="bg-white shadow-lg rounded-xl w-full max-w-5xl grid grid-cols-1 md:grid-cols-2 overflow-hidden">
      <!-- Left: Add Task -->
      <div class="p-8 border-r border-gray-200">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">+ Add a Task</h2>

        <form @submit.prevent="addTask" class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
            <input
              v-model="title"
              type="text"
              placeholder="e.g. Clean home"
              class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm"
              required
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea
              v-model="description"
              placeholder="Optional description..."
              rows="3"
              class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none shadow-sm"
            ></textarea>
          </div>
          <button
            type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg shadow-md transition duration-200"
          >
            Add
          </button>
        </form>
      </div>

      <!-- Right: Task List -->
      <div class="p-8 bg-gray-50">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">📋 Tasks</h2>

        <div v-if="tasks.length === 0" class="text-center text-gray-500 mt-10">
          <p>No tasks yet.</p>
        </div>

        <div
          v-for="task in tasks"
          :key="task.id"
          class="bg-white border border-gray-200 rounded-lg p-4 mb-4 shadow-sm hover:shadow-md transition"
        >
          <div class="flex justify-between items-center">
            <div>
              <h3 class="text-lg font-semibold text-gray-900">{{ task.title }}</h3>
              <p class="text-sm text-gray-600 mt-1" v-if="task.description">{{ task.description }}</p>
            </div>
            <button
              @click="markDone(task.id)"
              class="ml-4 px-4 py-1 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg shadow-sm"
            >
              Done
            </button>
          </div>
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
