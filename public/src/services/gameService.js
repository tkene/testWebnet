import api from './api'

export const gameService = {
  // Initialiser le jeu
  async initializeGame() {
    const response = await api.post('/game/initialize')
    return response.data
  },

  // Obtenir l'ordre des couleurs
  async getColorOrder() {
    const response = await api.get('/game/color-order')
    return response.data
  },

  // Générer un nouvel ordre de couleurs
  async generateNewColorOrder() {
    const response = await api.post('/game/color-order/new')
    return response.data
  },

  // Réorganiser l'ordre des couleurs
  async reorderColors(index, direction) {
    const response = await api.post('/game/color-order/reorder', {
      index,
      direction
    })
    return response.data
  },

  // Confirmer l'ordre des couleurs
  async confirmColorOrder() {
    const response = await api.post('/game/color-order/confirm')
    return response.data
  },

  // Obtenir l'ordre des valeurs
  async getValuesOrder() {
    const response = await api.get('/game/values-order')
    return response.data
  },

  // Générer un nouvel ordre de valeurs
  async generateNewValuesOrder() {
    const response = await api.post('/game/values-order/new')
    return response.data
  },

  // Réorganiser l'ordre des valeurs
  async reorderValues(index, direction) {
    const response = await api.post('/game/values-order/reorder', {
      index,
      direction
    })
    return response.data
  },

  // Confirmer l'ordre des valeurs
  async confirmValuesOrder() {
    const response = await api.post('/game/values-order/confirm')
    return response.data
  },

  // Confirmer le nombre de cartes
  async confirmCardsNumber(numberOfCards) {
    const response = await api.post('/game/cards-number', {
      numberOfCards
    })
    return response.data
  },

  // Obtenir la main non triée
  async getUnsortedHand() {
    const response = await api.get('/game/unsorted-hand')
    return response.data
  },

  // Obtenir la main triée
  async getSortedHand() {
    const response = await api.get('/game/sorted-hand')
    return response.data
  },

  // Réinitialiser le jeu
  async resetGame() {
    const response = await api.post('/game/reset')
    return response.data
  }
}
