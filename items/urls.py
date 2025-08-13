from django.urls import path

from .views import (
    ItemListView,
    ItemDetailView,
    ItemCreateView,
    ItemUpdateView,
    ItemDeleteView,
)

urlpatterns = [
    path('', ItemListView.as_view(), name='item_list'),
    path('new/', ItemCreateView.as_view(), name='item_create'),
    path('<int:pk>/', ItemDetailView.as_view(), name='item_detail'),
    path('<int:pk>/edit/', ItemUpdateView.as_view(), name='item_update'),
    path('<int:pk>/delete/', ItemDeleteView.as_view(), name='item_delete'),
]