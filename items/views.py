from django.urls import reverse_lazy
from django.views.generic import ListView, DetailView, CreateView, UpdateView, DeleteView

from .models import Item


class ItemListView(ListView):
    model = Item
    ordering = ['-id']


class ItemDetailView(DetailView):
    model = Item


class ItemCreateView(CreateView):
    model = Item
    fields = ['name', 'description']
    success_url = reverse_lazy('item_list')


class ItemUpdateView(UpdateView):
    model = Item
    fields = ['name', 'description']
    success_url = reverse_lazy('item_list')


class ItemDeleteView(DeleteView):
    model = Item
    success_url = reverse_lazy('item_list')
