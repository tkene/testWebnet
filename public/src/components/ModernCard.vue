<script setup>
defineProps({
  title: {
    type: String,
    default: ''
  },
  subtitle: {
    type: String,
    default: ''
  },
  emoji: {
    type: String,
    default: ''
  },
  cardClass: {
    type: String,
    default: ''
  },
  isMoving: {
    type: Boolean,
    default: false
  },
  fullscreen: {
    type: Boolean,
    default: false
  }
})
</script>

<template>
  <div class="modern-card" :class="[cardClass, { 'fullscreen-card': fullscreen }]">
    <div class="card-header" v-if="title || $slots.header">
      <div class="header-content">
        <h1 class="card-title" v-if="title">
          <span class="title-text">{{ title }}</span>
          <span class="title-emoji" v-if="emoji">{{ emoji }}</span>
        </h1>
        <p class="card-subtitle" v-if="subtitle">{{ subtitle }}</p>
        <slot name="header"></slot>
      </div>
    </div>

    <div class="card-content" :class="{ 'is-moving': isMoving }">
      <slot></slot>
    </div>

    <div class="card-actions" v-if="$slots.actions">
      <slot name="actions"></slot>
    </div>
  </div>
</template>

<style scoped>
/* Card principale avec glassmorphism */
.modern-card {
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border-radius: 24px;
  box-shadow: 
    0 8px 32px rgba(0, 0, 0, 0.1),
    0 2px 8px rgba(0, 0, 0, 0.05),
    inset 0 1px 0 rgba(255, 255, 255, 0.8);
  padding: 2rem;
  max-width: 700px;
  width: 100%;
  max-height: 95vh;
  display: flex;
  flex-direction: column;
  border: 1px solid rgba(255, 255, 255, 0.2);
}

/* Header moderne */
.card-header {
  margin-bottom: 2rem;
}

.header-content {
  text-align: center;
}

.card-title {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  margin-bottom: 0.75rem;
  font-size: 1.75rem;
  font-weight: 700;
  color: #1a1a2e;
  letter-spacing: -0.02em;
}

.title-emoji {
  font-size: 1.5rem;
  animation: float 3s ease-in-out infinite;
}

@keyframes float {
  0%, 100% { transform: translateY(0px); }
  50% { transform: translateY(-5px); }
}

.card-subtitle {
  color: #6b7280;
  font-size: 1rem;
  font-weight: 400;
  margin: 0;
}

/* Contenu de la carte */
.card-content {
  flex: 1;
  min-height: 0;
  transition: opacity 0.3s ease;
}

.card-content.is-moving {
  opacity: 0.7;
}

/* Actions */
.card-actions {
  display: flex;
  gap: 1rem;
  justify-content: center;
  margin-top: 1.5rem;
  flex-shrink: 0;
}

/* Mode plein écran pour les pages de cartes */
.modern-card.fullscreen-card {
  max-width: 95vw;
  max-height: 95vh;
  overflow-y: auto;
}

/* Responsive */
@media (max-width: 640px) {
  .modern-card {
    padding: 1.5rem;
    border-radius: 20px;
  }
  
  .card-title {
    font-size: 1.5rem;
  }
  
  .card-actions {
    flex-direction: column;
  }
}
</style>

