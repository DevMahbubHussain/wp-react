import { createRoot } from 'react-dom/client';
import { RouterProvider } from 'react-router-dom';
import './main.scss'; // global css
import { QueryClient, QueryClientProvider } from '@tanstack/react-query';
import routes from './routes/routes';


const queryClient = new QueryClient();
createRoot(document.getElementById("jobfind")!).render(
    <QueryClientProvider client={queryClient}>
        <RouterProvider router={routes}></RouterProvider>
    </QueryClientProvider>
);