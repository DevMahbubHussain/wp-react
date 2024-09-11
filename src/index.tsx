import { createRoot } from 'react-dom/client';
import App from './App';
import './main.scss'; // global css
import { RouterProvider } from 'react-router-dom';
import routes from './routes/routes';

// const container = document.getElementById('jobfind');
// if (container) {
//   const root = createRoot(container);
//   root.render(<App />);
// } else {
//   console.error('Container element not found');
// }


createRoot(document.getElementById("jobfind")!).render(
    <RouterProvider router={routes}></RouterProvider>
);